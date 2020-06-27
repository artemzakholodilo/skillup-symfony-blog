$(document).ready(function (e) {
    let badge = $('[data-id="users-count"]'),
        badgeValue = localStorage.getItem('count') || 0;

    badge.text(badgeValue);

    $('.promote-user').click(function (e) {
        let sendData = {},
            me = document.querySelector('script[data-route]');

        sendData.id = 10;

        $.ajax({
            method: 'put',
            data: sendData,
            url: me.getAttribute('data-route'),
            success: (data) => {
                let badgeValue = badge.text();
                console.log(badgeValue);
                badgeValue++;
                localStorage.setItem('count', badgeValue);
                badge.text(badgeValue);
            },
            error: (error) => {
                console.error(error)
            }
        });
    });
});