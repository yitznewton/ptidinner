(function () {
    document.querySelector('.confirm-on-submit').addEventListener('submit', function (e) {
        var response = window.confirm('Are you sure?')

        if (response) {
            return true;
        }

        e.preventDefault();
        return false;
    });
})();
