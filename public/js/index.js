// ------------------------------ animation home-page-----------------------------------

var basicTimeline = anime.timeline();

    basicTimeline
    .add({
        targets: "#basicTimeline .first.el",
        translateX: 1200,
        easing: "easeOutExpo",
        delay: 1500,
    })
    .add({
        targets: "#basicTimeline .second.el",
        translateX: 1200,
        easing: "easeOutExpo",
    })
    .add({
        targets: "#basicTimeline .third.el",
        translateX: 1650,
        easing: "easeOutExpo",
    })
    .add({
        targets: "#basicTimeline .fourth.el",
        translateX: 1750,
        easing: "easeOutExpo",
    })
    .add({
        targets: "#basicTimeline .fiveth.el",
        translateX: 1650,
        easing: "easeOutExpo",
    });

    //-----------------------------------------Calendar----------------------------------

    window.onload = () => {
        let calendarElt = document.querySelector('#calendrier')

        let calendar = new FullCalendar.Calendar(calendarElt, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            timeZone: 'Europe/Paris',
            headerToolbar: {
                start: 'prev',
                center: 'title',
                end: 'next'
            }
        })

        calendar.render()
    }
