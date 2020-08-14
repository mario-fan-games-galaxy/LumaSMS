window.addEventListener('keydown', function(e){
    if(e.key != 'Escape'){
        return;
    }
    
    document.getElementById('nav-checkbox').checked = false;
});