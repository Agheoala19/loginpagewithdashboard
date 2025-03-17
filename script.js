function setcookie() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("pass").value;

    document.cookie="myemail="+email+";path=http://localhost/web6pm/";
    document.cookie="mypswd="+password+";path=http://localhost/web6pm/";
}

function getcookiedata() {
    var em = getCookie('myemail');
    var pswd = getCookie('mypswd');

    document.getElementById("email").value = em;
    document.getElementById("pass").value = pswd;
}

function getCookie(cname) {
    var name = cname + '=';
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while(c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if(c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function showSidebar() {
    const sidebar = document.querySelector('.sidebar-nav');
    sidebar.style.display= 'flex';
}

function hideSidebar() {
    const sidebar = document.querySelector('.sidebar-nav');
    sidebar.style.display= 'none';
}

function searchBar() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById('list');
    li = ul.getElementsByTagName('li');

    for(i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName('a')[0];
        if(a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        }else {
            li[i].style.display = 'none';
        }
    }
}