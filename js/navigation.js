// Navigation active link when clicking on icon
const icons = document.querySelectorAll('.nav-link');
icons.forEach(clickedTab => {
    clickedTab.addEventListener('click', () => {
        icons.forEach(tab => {
            tab.classList.remove('active');
        });
        clickedTab.classList.add('active');
    });
});

function setActive() {
      aObj = document.getElementById('isActive').getElementsByTagName('a');
      for(i=0;i<aObj.length;i++) {
        if(document.location.href.indexOf(aObj[i].href)>=0) {
          aObj[i].className='active';
        }
      }
    }

window.onload = setActive;