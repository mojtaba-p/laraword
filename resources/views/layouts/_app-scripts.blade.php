<script>
    // save new box
    async function save(inputname, inputprivate) {
        const response = await fetch(@js(route('dashboard.boxes.store')), {
            method: 'post',
            body: JSON.stringify({name: inputname, private: inputprivate}),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
            }
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    // fetch boxes
    async function fetchBoxes() {
        const response = await fetch(@js(route('dashboard.boxes.index')), {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
            }
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    async function fetchBookmarks() {
        const response = await fetch(@js(route('dashboard.bookmarks.index')), {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
            }
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    // runs when user selected a box for send selected boxes to api
    function boxSelected(parent, url) {
        let data = parent._x_dataStack[0];
        bookmarkDiv = parent.closest('.bookmarkContainer');
        bookmarkData = bookmarkDiv._x_dataStack[0];

        data.$nextTick(() => {
            data.syncing = true;
            syncBoxes(data.selectedBoxes, url)
                .then(response => {
                    if (response.boxes != undefined) {
                        data.selectedBoxes = response.boxes;
                        bookmarkData.bookmarked = true;
                    } else {
                        bookmarkData.bookmarked = false;
                    }
                    data.syncing = false;
                });
        });

    }

    // fetches boxes from api
    async function syncBoxes(boxes, url) {
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify({boxes: boxes}),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
            }
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    // get selected boxes for specific bookmark(article)
    function refreshBoxes(element, url) {
        element = element.closest('.bookmarkContainer').querySelector('form');
        let data = element._x_dataStack[0];
        data.syncing = true;
        getSyncedBoxes(url)
            .then(response => {
                if (response.boxes) {
                    data.selectedBoxes = response.boxes;
                }
                data.syncing = false;
            });
    }

    // get boxes that synced to specific bookmark
    async function getSyncedBoxes(url) {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
            }
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }
</script>
