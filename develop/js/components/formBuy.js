const element = document.querySelector('.form-buy');
const errorElement = element ? element.querySelector('.error') : null;

function setLoading() {
  element.classList.add('is-loading');
}

function unsetLoading() {
  element.classList.remove('is-loading');
}

if (element) {
  element.addEventListener('submit', (event) => {
    errorElement.textContent = '';
    event.preventDefault();
    setLoading();
    fetch(element.action, {
      method: element.method,
      credentials: 'same-origin',
      body: new FormData(element),
    }).then(response => response.json()).then((data) => {
      if (data.status === 201) {
        window.location = data.redirect;
      } else {
        errorElement.textContent = data.message;
      }
      unsetLoading();
    }).catch((res) => {
      console.error(res);
      errorElement.textContent = 'Unknown Server Error.';
      unsetLoading();
    });
  });
}
