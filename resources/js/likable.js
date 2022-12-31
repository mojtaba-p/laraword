function like(type, id) {
    return fetch('/like/' + type + '/' + id, {
        method: 'post',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
        }
    }).then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Server response wasn\'t OK');
        }
    })
        .then((result) => {
            return result.likes_count;
        })
}
