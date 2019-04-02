/* eslint-disable no-underscore-dangle */

import '@babel/polyfill/';
import 'airbnb-browser-shims/browser-only';
import './components/formBuy';
import './components/formCheckout';
import './components/updateCart';
import Popup from './components/Popup';

document.__popups = [];
[...document.querySelectorAll('.popup')].forEach((popupElement) => {
  document.__popups.push(new Popup(popupElement));
});
