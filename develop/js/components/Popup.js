const FOCUSABLE_ELEMENTS = [
  'a[href]:not([tabindex^="-"]):not([inert])',
  'area[href]:not([tabindex^="-"]):not([inert])',
  'input:not([disabled]):not([inert])',
  'select:not([disabled]):not([inert])',
  'textarea:not([disabled]):not([inert])',
  'button:not([disabled]):not([inert])',
  'iframe:not([tabindex^="-"]):not([inert])',
  'audio:not([tabindex^="-"]):not([inert])',
  'video:not([tabindex^="-"]):not([inert])',
  '[contenteditable]:not([tabindex^="-"]):not([inert])',
  '[tabindex]:not([tabindex^="-"]):not([inert])',
];


class Popup {
  constructor(element) {
    const popup = this;
    const { id } = element;
    const linkElements = document.querySelectorAll(`a[data-target="popup"][data-href="${id}"]`);
    const buttonCloseElement = element.querySelector('.button-close');

    function onLinkClick(event) {
      popup.open();
      event.preventDefault();
      popup.openedLinkElement = event.target;
    }

    [...linkElements].forEach(linkElement => linkElement.addEventListener('click', onLinkClick));
    element.addEventListener('click', (event) => {
      if (event.target === element) {
        this.close();
      }
    });
    buttonCloseElement.addEventListener('click', () => {
      popup.close();
    });

    this.element = element;
    this.onKeydown = (event) => {
      if (event.key === 'Escape') {
        this.close();
      }
    };
    this.onLinkFocus = (event) => {
      const closestPopup = event.target.closest('.popup');
      if (!closestPopup || closestPopup !== element) {
        this.close();
      }
    };
  }

  open() {
    const { element } = this;
    element.hidden = false;
    element.firstElementChild.tabIndex = 0;
    element.firstElementChild.focus();
    document.body.classList.add('has-open-popup');
    document.addEventListener('keydown', this.onKeydown);
    [...document.querySelectorAll(FOCUSABLE_ELEMENTS.join(','))].forEach((linkElement) => {
      linkElement.addEventListener('focus', this.onLinkFocus);
    });
  }

  close() {
    const { element } = this;
    element.hidden = true;
    element.firstElementChild.tabIndex = -1;
    document.body.classList.remove('has-open-popup');
    document.removeEventListener('keydown', this.onKeydown);
    [...document.querySelectorAll(FOCUSABLE_ELEMENTS.join(','))].forEach((linkElement) => {
      linkElement.removeEventListener('focus', this.onLinkFocus);
    });
    if (this.openedLinkElement) {
      this.openedLinkElement.focus();
      this.openedLinkElement = null;
    }
  }
}

export default Popup;
