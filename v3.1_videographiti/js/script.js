//  toggle menu navigation
function toggle() {
    document.querySelector('html').classList.toggle('menu__open');

    document.querySelector('.menu-btn__hamburger').classList.toggle('open');
    document.querySelector('.main-nav').classList.toggle('open');
}



// global navigation display on/off by scroll up/down
(function() {
    const target = document.getElementById('header'),
    height = 56;
    let offset = 0,
    lastPosition = 0,
    ticking = false;

    function onScroll() {
        if(document.querySelector('html').classList.contains('menu__open')) {
            // when menu overlay is open, do not hide header
            target.classList.remove('head-animation');
        }else {

            if (lastPosition > height) {
                if (lastPosition > offset) {
                    target.classList.add('head-animation');
                } else {
                    target.classList.remove('head-animation');
                }
                offset = lastPosition;
            }
        }
    }

    window.addEventListener('scroll', function(e) {
        lastPosition = window.scrollY;
        if (!ticking) {
            window.requestAnimationFrame(function() {
                onScroll(lastPosition);
                ticking = false;
            });
            ticking = true;
        }
    });
	
	document.querySelectorAll('.main-nav a').forEach((item) => {
		item.addEventListener('click', toggle)
	});
})();


// toggle submenu
function toggleMenu(element) {
    element.classList.toggle('open');
    element.firstChild.classList.toggle('open');
    element.nextElementSibling.classList.toggle('open');
}

// category tab
function toggleCategory(element, category) {
    if(!element.classList.contains('selected__category')) {
        // update class list of tab-button-element
        document.querySelector('.selected__category').classList.toggle('selected__category');
        element.classList.toggle('selected__category');

        // update active work-elements
        var currActiveElements = document.querySelectorAll('.active__category');
        for(var i = 0; i < currActiveElements.length; i++) {
            currActiveElements[i].classList.toggle('active__category');
        }

        var newActiveElements = document.querySelectorAll('.work');
        for(var i = 0; i < newActiveElements.length; i++) {
            if(newActiveElements[i].classList.contains(category)) {
                newActiveElements[i].classList.toggle('active__category');
            }
        }
        
    }
}

// open modal
function modalDisplay(postId) {
    ajax(postId);


    // hide header
    document.getElementById('header').classList.add('head-animation');
    
    // disable scroll bar
    document.querySelector('html').classList.add('modal__open');

    // change checked status
    var checkbox = document.getElementById('cp_trigger');
    var checked = checkbox.checked;
    if(checked) {
        checkbox.checked = false;
    }else {
        checkbox.checked = true;
    }
}


function ajax(id){
    var ajaxRequest = new XMLHttpRequest(); 
    ajaxRequest.onreadystatechange = function (){	
        if( ajaxRequest.readyState === 4 ){
            if( ( 200 <= ajaxRequest.status && ajaxRequest.status < 300 ) ){
                var _returnValues = JSON.parse(ajaxRequest.responseText);
                insertData(_returnValues[0]["post"])
            }else{
				insertData(null)
            }
        }
    };
    ajaxRequest.open( "POST" , ajaxurl , true );
    ajaxRequest.setRequestHeader( "content-type", "application/x-www-form-urlencoded ; charset=UTF-8" );
    var ajaxData = "action=postInfo&id=" + id;
    ajaxRequest.send(ajaxData);
}


// insert data
function insertData(post) {
    var modalTitle = document.getElementById('modal-title');
    var modalDate = document.querySelector('.cp_post-date');
	var modalBody = document.getElementById('modal-body');
	
	if(post != null) {
		modalTitle.innerText = post.post_title;
		modalBody.innerHTML = post.post_content;
		modalDate.innerHTML = '<i class="fas fa-calendar"></i>' + post.post_date;
	}else {
		modalTitle.innerText = '404 Not Found.';
		modalBody.innerHTML = '<p><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>お探しのページは見つかりませんでした。</p>';
		modalDate.innerHTML = '<i class="fas fa-calendar"></i>YYYY-MM-DD';
	}
}



// close modal
function closeModal() {
    // enable scroll bar
    document.querySelector('html').classList.remove('modal__open');
    setTimeout('clearModalElement();', 500);
}

function clearModalElement() {
    var modalTitle = document.getElementById('modal-title');
    var modalDate = document.querySelector('.cp_post-date');
	var modalBody = document.getElementById('modal-body');
    modalTitle.innerHTML = '';
    modalDate.innerHTML = '';
	modalBody.innerHTML = '';
}


// scroll to page top
var pageTopBtn = document.getElementById('page-top');

pageTopBtn.onclick = function(e) {
    window.scrollTo({top: 0, behavior: 'smooth'});

    // イベントの初期動作を停止
    if (e.preventDefault) {
        e.preventDefault();
    } else {
        e.returnValue = false;
    }
};