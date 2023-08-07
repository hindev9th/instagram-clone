import $ from 'jquery';

export function formatTime(time) {
    const startTime = new Date(time);
    const endTime = new Date();
    const seconds = Math.floor((endTime - startTime) / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30);
    const years = Math.floor(months / 12);

    if (seconds < 0) {
        return startTime.toLocaleString();
    }

    if (seconds < 60) {
        return `${seconds} seconds ago`;
    }

    if (minutes < 60) {
        return `${minutes} minutes ago`;
    }

    if (hours < 24) {
        return `${hours} hours ago`;
    }

    if (days < 7) {
        return `${days} days ago`;
    }

    if (days < 30) {
        return `${weeks} weeks ago`;
    }

    if (months < 12) {
        return `${months} months ago`;
    }

    return `${years} years ago`;
}

export function getImage(image){
    image = (image == null) ? 'https://hatalandscape.com/public/no-avatar.jpg' : window.Laravel.baseUrl + '/storage/' + image;
    return image;
}

export function getNames(users,auth_user) {
    var names = [];
    for (var index in users) {
        if (users[index].id !== auth_user.id) {
            names.push(users[index].username);
        }
    }
    return names.join(', ');
}

export function showNotify(message){
    function remove(){
        toast.style.animation = 'notify-frame-out .5s reverse ease-in-out';
        toast.classList.add('remove');
        setTimeout(function (){
            toast.remove();
        },500);
    }
    const closeBtn = document.createElement('button');
    closeBtn.className = 'ml-2 mb-1 close close-notify';
    closeBtn.setAttribute('data-dismiss','toast');
    closeBtn.setAttribute('aria-label','Close');
    closeBtn.style.position = 'absolute';
    closeBtn.style.top = '5px';
    closeBtn.style.right = '5px';
    closeBtn.innerHTML = `<span aria-hidden="true">&times;</span>`;
    closeBtn.addEventListener('click', function () {
        remove();
    });


    const toast = document.createElement('div')
    toast.className = 'toast bg-white m-2';
    toast.setAttribute('data-autohide','false');
    toast.style.position = 'relative';
    toast.innerHTML =  `<div class="toast-header">
                      <strong class="mr-auto">Notification</strong>
                    </div>
                    <div class="toast-body">
                      ${message}
                    </div>`


    toast.append(closeBtn);
    $('#notify').append(toast);

    toast.classList.add('show');
    toast.style.animation = 'notify-frame .5s ease-in-out';
    setTimeout(function (){
        remove();
    },5000)

    return true;
}

export function formatNumber(number) {
    return number.toLocaleString('en-US');
}

export function extractTagsFromString(inputString) {
    const regex = /@([\w.]+)/g;
    // return inputString.replace(regex, '<router-link to="/$1">$&</router-link>');
    return inputString.replace(
        /@\w+/g,
        (user) => `<router-link :to="'/${user.slice(1)}'">@${user.slice(1)}</router-link>`);
}
