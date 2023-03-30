// Function found here: https://stackoverflow.com/questions/21070101/show-hide-div-using-javascript
function toggle (elements, specifiedDisplay) {
  var element, index;

  elements = elements.length ? elements : [elements];
  for (index = 0; index < elements.length; index++) {
    element = elements[index];

    if (isElementHidden(element)) {
      element.style.display = '';

      // If the element is still hidden after removing the inline display
      if (isElementHidden(element)) {
        element.style.display = specifiedDisplay || 'block';
      }
    } else {
      element.style.display = 'none';
    }
  }
  function isElementHidden (element) {
    return window.getComputedStyle(element, null).getPropertyValue('display') === 'none';
  }
}

window.addEventListener('DOMContentLoaded', (event) => {

  document.querySelector('a#toggle-all').addEventListener('click', () => {
    toggle(document.querySelectorAll('li.folder ul'));
  });

  document.querySelectorAll('div.tree a').forEach((link) => {
    link.addEventListener('click', (event) => {
      toggle(document.getElementById(event.target.dataset.toggle));
      event.preventDefault();
    });
  });

});
