(function () {
    document.querySelector('.confirm-on-submit').addEventListener('submit', function (e) {
        var response = window.confirm('Are you sure?')

        if (response) {
            return true;
        }

        e.preventDefault();
        return false;
    });

    var approvedCheckbox = document.querySelector('#dinnerbundle_ad_proofApproved');

    document.querySelector('.approve-button').addEventListener('click', function () {
        approvedCheckbox.checked = true;
    });
})();
