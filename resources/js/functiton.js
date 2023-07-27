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
    var html = `
                  <div class="toast m-4" data-autohide="false" style="width: 250px;position: fixed; top: 0; right: 0;">
                    <div class="toast-header">
                      <strong class="mr-auto">Notification</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="toast-body">
                      ${message}
                    </div>
                  </div>`
    $('body').append(html);
    $('.toast').toast('show');
    setTimeout(function (){
        $('.toast').toast('hide');
    },5000);
    return true;
}

export function formatNumber(number) {
    return number.toLocaleString('en-US');
}

export function extractTagsFromString(inputString) {
    const baseUrl = window.Laravel.baseUrl;
    const regex = /@([\w.]+)/g;
    const replacedString = inputString.replace(regex, '<a href="' + baseUrl + '/profile/$1">$&</a>');
    return replacedString;
}
