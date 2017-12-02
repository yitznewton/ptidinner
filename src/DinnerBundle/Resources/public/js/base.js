(function () {
    let iterateSelector = function(selector, callback) {
        var results = document.querySelectorAll(selector);
        for (var item of results) {
            callback(item);
        }
    };

    iterateSelector('.confirm-on-submit', function (s) {
        s.addEventListener('submit', function (e) {
            var response = window.confirm('Are you sure?');

            if (response) {
                return true;
            }

            e.preventDefault();
            return false;
        });
    });

    var sentToPrinterInput = document.querySelector('#dinnerbundle_ad_sentToPrinter');
    var proofFromPrinterCheckbox = document.querySelector('#dinnerbundle_ad_proofFromPrinter');
    var approvedCheckbox = document.querySelector('#dinnerbundle_ad_proofApproved');

    iterateSelector('.sent-to-printer-button', function (s) {
        s.addEventListener('click', function () {
                sentToPrinterInput.value = (new Date().toISOString().slice(0,10));
                this.form.submit();
        });
    });

    iterateSelector('.from-printer-button', function (s) {
        s.addEventListener('click', function () {
            proofFromPrinterCheckbox.checked = true;
            this.form.submit();
        });
    });

    iterateSelector('.approve-button', function (s) {
        s.addEventListener('click', function () {
            proofFromPrinterCheckbox.checked = true;
            approvedCheckbox.checked = true;
            this.form.submit();
        });
    });
})();
