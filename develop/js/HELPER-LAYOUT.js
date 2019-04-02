/*
Shows grid on ctrl + l

Layout Settings:
Total Width: 1720px
Number of columns: 20
Gutter on outside
Gutter Width: 20px
Column Width: 66px
*/

const columns = 16;
const gutterWidth = 48;
const columnWidth = 48;

let isGridVisible = false;
let isWidthInfoVisible = false;
let gridContainerElement;
let widthInfoElement;

function generateGridHTML() {
  const bodyElement = document.querySelector('body');
  gridContainerElement = document.createElement('div');
  Object.assign(gridContainerElement.style, {
    position: 'fixed',
    zIndex: '100',
    left: '0',
    right: '0',
    top: '0',
    bottom: '0',
    pointerEvents: 'none',
    display: 'flex',
    height: '100%',
    marginLeft: 'auto',
    marginRight: 'auto',
    alignItems: 'stretch',
    justifyContent: 'center',
  });
  for (let i = 0; i < columns; i += 1) {
    const divElement = document.createElement('div');
    Object.assign(divElement.style, {
      flex: `${columnWidth}px 0 0`,
      marginLeft:  `${gutterWidth * 0.5}px`,
      marginRight: `${gutterWidth * 0.5}px`,
      background: 'hsla(0, 0%, 66%, 0.1)',
    });
    gridContainerElement.appendChild(divElement);
  }
  bodyElement.appendChild(gridContainerElement);
}

function updateWidthInfo() {
  const width = window.innerWidth;
  const roundedWidth = Math.round(window.innerWidth / 16) * 16;
  widthInfoElement.innerText = `${width} / ${roundedWidth}`;
}

function generateWidthInfoElement() {
  const bodyElement = document.querySelector('body');
  widthInfoElement = document.createElement('div');
  Object.assign(widthInfoElement.style, {
    position: 'fixed',
    zIndex: '100',
    right: '0',
    bottom: '0',
    backgroundColor: 'black',
    color: 'white',
    padding: '1em',
  });
  updateWidthInfo();
  bodyElement.appendChild(widthInfoElement);
}

function onKeydown(event) {
  if (event.altKey === true
  && event.ctrlKey === true) {
    if (event.keyCode === 76) { // L key
      if (isGridVisible === false) {
        generateGridHTML();
        isGridVisible = true;
        console.log('show grid');
      } else {
        gridContainerElement.remove();
        isGridVisible = false;
        console.log('hide grid');
      }
    } else if (event.keyCode === 87) { // W key
      if (isWidthInfoVisible === false) {
        generateWidthInfoElement();
        isWidthInfoVisible = true;
        console.log('show width info');
      } else{
        widthInfoElement.remove();
        isWidthInfoVisible = false;
        console.log('hide width info');
      }
    }
  }
}

function onResize() {
  if (widthInfoElement) {
    updateWidthInfo();
  }
}

document.addEventListener('keydown', onKeydown);
window.addEventListener('resize', onResize);
