var Manage = {
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        $('.j-delete-photo').on('click', function () {
            var photoId = $(this).data('id');
            var $imgWrap = $('[data-photoId=' + photoId + ']'),
                data = {
                };

            self.postData('index.php?r=product/delete-image&id=' + photoId, data, function () {
                $imgWrap.remove();
            })
        });
    },
    postData: function (url, data, callback) {
        $.ajax({
            url: url,
            data: data,
            method: 'post',
            success: function (response) {
                if (typeof callback == 'function') callback(response);
            },
        })
    }
};

(function () {
    Manage.init();
})();