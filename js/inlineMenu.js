(function (Drupal, once) {
  Drupal.behaviors.inlineMenuBehavior = {
    attach: function (context, settings) {
      let inlineMenuFormElement = once('inlineMenuBehavior', '#field-inline-menu-values', context);
      inlineMenuFormElement.forEach(function(elem) {
        // make the top row collapsible
        let headerRow = document.querySelector('#field-inline-menu-values thead .field-label');
        console.log(headerRow);
        headerRow.addEventListener('click', function(e) {
          let tbody = e.target.parentElement.parentElement.nextElementSibling;
          e.target.classList.toggle("collapse");
          tbody.classList.toggle("collapsed");
        });
        let inlineMenuLinks = document.querySelectorAll('[id*=edit-field-inline-menu-]');
        for (let inlineMenuLink of inlineMenuLinks) {
          let elemId = inlineMenuLink.id;
          if (!elemId.includes('nest-level')) {
            continue;
          }
          let parentDataCell = inlineMenuLink.closest('td');
          let level = inlineMenuLink.value;
          parentDataCell.style.paddingLeft = (level*2) + "rem";
          if (level == 1) {
            parentDataCell.style.background = "whitesmoke";
            parentDataCell.style.backgroundClip = "content-box";
          }
          else if (level == 2) {
            parentDataCell.style.background = "lightgray";
            parentDataCell.style.backgroundClip = "content-box";
          }
        }
      });
    }
  };
})(Drupal, once);
