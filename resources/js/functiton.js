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
    image = (image == null) ? 'https://t3.ftcdn.net/jpg/01/18/01/98/360_F_118019822_6CKXP6rXmVhDOzbXZlLqEM2ya4HhYzSV.jpg' : window.Laravel.baseUrl + '/storage/' + image;
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
