/* global Stripe */
/* eslint no-param-reassign: "warn" */
const element = document.querySelector('.form-checkout');
let paymentMethod = null;
const stripeStyle = {
  base: {
    fontFamily: '"Helvetica Neue", "Helvetica", sans-serif',
    fontSize: '18px',
    color: 'black',
  },
};

function setStripeToken(token) {
  const hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  element.appendChild(hiddenInput);
}

function setLoading() {
  element.classList.add('is-loading');
  [...element.querySelectorAll('input, textarea')].forEach(inputElement => inputElement.setAttribute('readonly', true));
  [...element.querySelectorAll('button')].forEach(buttonElement => buttonElement.setAttribute('disabled', true));
  [...element.querySelectorAll('.error')].forEach((errorElement) => {
    errorElement.textContent = '';
  });
}

function unsetLoading() {
  element.classList.remove('is-loading');
  [...element.querySelectorAll('input, textarea')].forEach(inputElement => inputElement.removeAttribute('readonly'));
  [...element.querySelectorAll('button')].forEach(buttonElement => buttonElement.removeAttribute('disabled'));
}

function changeSubmitText(submitElement, text, buttonTextDefault) {
  if (text.length > 0) {
    submitElement.textContent = text;
  } else {
    submitElement.textContent = buttonTextDefault;
  }
}

function changePaymentMethod(paymentMethodElements) {
  [...paymentMethodElements].forEach((paymentMethodElement) => {
    if (paymentMethodElement.dataset.paymentMethod === paymentMethod) {
      paymentMethodElement.hidden = false;
    } else {
      paymentMethodElement.hidden = true;
    }
  });
}

function showFieldErros(data) {
  let isFocused = false;
  console.log(data);
  Object.keys(data).forEach((key) => {
    const inputElement = element.querySelector(`input[name="${key}"]`);
    if (inputElement) {
      const errorElement = document.createElement('div');
      errorElement.classList.add('error');
      errorElement.textContent = Object.values(data[key].message)[0];
      inputElement.parentElement.appendChild(errorElement);
      if (!isFocused) {
        inputElement.focus();
        isFocused = true;
      }
    }
  });
}

function getClientSecret() {
  return fetch('shop-api/get-client-secret').then(response => response.json()).then(data => data.clientSecret).catch((exception) => {
    console.error(exception);
    const errorElement = element.querySelector('.form-checkout__submit .error');
    errorElement.textContent = 'Unknown Server Error.';
  });
}


function submit() {
  fetch(element.action, {
    method: element.method,
    credentials: 'same-origin',
    body: new FormData(element),
  }).then(response => response.json()).then((data) => {
    if (data.status === 201) {
      window.location = data.redirect;
    } else if (data.key === 'error.merx.fieldsvalidation') {
      showFieldErros(data.details);
    } else {
      const errorElement = element.querySelector('.form-checkout__submit .error');
      errorElement.textContent = data.message;
    }
    unsetLoading();
  }).catch((res) => {
    console.error(res);
    const errorElement = element.querySelector('.form-checkout__submit .error');
    errorElement.textContent = 'Unknown Server Error.';
    unsetLoading();
  });
}

function initStripe() {
  const stripePublishableKey = element.querySelector('input[name="stripePublishableKey"]').value;
  const stripe = Stripe(stripePublishableKey);
  const stripeElements = stripe.elements();

  const stripeCardElement = document.querySelector('#stripe-card');
  const stripeSepaDebitElement = document.querySelector('#stripe-sepa-debit');

  const stripeCard = stripeElements.create('card', {
    style: stripeStyle,
    hidePostalCode: true,
  });

  const stripeSepaDebit = stripeElements.create('iban', {
    style: stripeStyle,
    supportedCountries: ['SEPA'],
    placeholderCountry: 'DE',
  });

  stripeCard.mount(stripeCardElement);
  stripeSepaDebit.mount(stripeSepaDebitElement);

  stripe.card = stripeCard;
  stripe.cardElement = stripeCardElement;

  stripe.sepaDebit = stripeSepaDebit;
  stripe.sepaDebitElement = stripeSepaDebitElement;

  return stripe;
}

if (element) {
  const stripe = initStripe();
  const shippingAddressElement = element.querySelector('#shipping-address');
  const checkboxShippingAddressElement = element.querySelector('input[name="useInvoiceAddressAsShippingAddress"]');
  const radioPaymentMethodElements = element.querySelectorAll('input[name="paymentMethod"]');
  const paymentMethodElements = element.querySelectorAll('label[data-payment-method]');
  const submitElement = element.querySelector('button[type="submit"]');
  const buttonTextDefault = submitElement.textContent;

  if (shippingAddressElement && checkboxShippingAddressElement) {
    checkboxShippingAddressElement.addEventListener('change', () => {
      shippingAddressElement.hidden = checkboxShippingAddressElement.checked;
    });
  }

  if (radioPaymentMethodElements) {
    [...radioPaymentMethodElements].forEach((radioPaymentMethodElement) => {
      radioPaymentMethodElement.addEventListener('change', () => {
        paymentMethod = radioPaymentMethodElement.value;
        const { submitText } = radioPaymentMethodElement.dataset;
        changeSubmitText(submitElement, submitText, buttonTextDefault);
        changePaymentMethod(paymentMethodElements);
      });
    });
  }

  element.addEventListener('submit', async (event) => {
    event.preventDefault();
    setLoading();
    if (element.checkValidity()) {
      if (paymentMethod === 'credit-card-sca') {
        const clientSecret = await getClientSecret();
        const cardElement = stripe.card;

        const { error } = await stripe.handleCardPayment(
          clientSecret, cardElement, {
            payment_method_data: {
              billing_details: {
                name: `${element.givenname.value} ${element.familyname}`,
                city: element.city,
              },
            },
          },
        );

        if (error) {
          unsetLoading();
          const errorElement = stripe.cardElement.parentElement.querySelector('.error');
          errorElement.textContent = error.message;
        } else {
          submit();
        }
      } else if (paymentMethod === 'sepa-debit') {
        const sourceData = {
          type: 'sepa_debit',
          currency: 'eur',
        };

        stripe.createSource(stripe.sepaDebit, sourceData).then((result) => {
          if (result.error) {
            unsetLoading();
            const errorElement = stripe.sepaDebitElement.parentElement.querySelector('.error');
            errorElement.textContent = result.error.message;
          } else {
            setStripeToken(result.source);
            submit();
          }
        });
      } else {
        submit();
      }
    } else {
      const errorElement = element.querySelector('.form-checkout__submit .error');
      errorElement.textContent = 'Ihre Angaben sind nicht vollständig.';
      unsetLoading();
    }
  });
}
