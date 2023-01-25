const likes = document.getElementsByClassName('like');

for (const like of likes) {
    like.addEventListener('click', function (event) {
        const likeLink = event.currentTarget;
        const link = likeLink.href;
        // Send an HTTP request with fetch to the URI defined in the href
        try {
            fetch(link)
            // Extract the JSON from the response
                .then(res => res.json())
            // Then update the icon
                .then(res => {
                    like.innerHTML = "Like - " + res.numberOfLikes;
                    if (res.isLikedByUser) {
                        likeLink.classList.remove("btn-secondary");
                        likeLink.classList.add("btn-success");
                    } else {
                        likeLink.classList.remove("btn-success");
                        likeLink.classList.add("btn-secondary");
                    }
                });
        } catch (err) {
            return(err);
        }
        event.preventDefault();
        return false;
    })
}
