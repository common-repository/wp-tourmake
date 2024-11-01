( function( $ ) {
    $('.wptm-tour-wrapper').each(function () {
       $scope = $(this);
       render_tour($scope);
    });

    function render_tour($scope) {
        var div = $('.wptm-tour-container')[0];
        var idtour = div.getAttribute('data-id');
        if(idtour)
        {
            var startingPov = {
                idPano: '',
                heading: '',
                pitch: '',
                zoom: 0
            };

            var idPano = div.getAttribute('data-pano');
            if(idPano){
                startingPov['idPano'] = idPano;
            }

            var heading = div.getAttribute("data-heading");
            if(heading){
                startingPov['heading'] = heading;
            }

            var pitch = div.getAttribute("data-pitch");
            if(pitch){
                startingPov['pitch'] = pitch;
            }

            var zoom = div.getAttribute("data-zoom");
            if(zoom){
                startingPov['zoom'] = zoom;
            }

            var Settings = (function () {
                var values = {
                    schema: "http",
                    locale: div.getAttribute('data-locale'),
                    id_tour: idtour,
                };
                return {
                    getParam: function (name) {
                        return values[name] ? values[name] : null;
                    },
                };
            })();

            var options = {
                language: Settings.getParam("locale"),
                menu: true,
                logo: false,
                flag: false
            };

            let uniqueId = Math.random().toString(36).substr(2, 16);
            div.setAttribute("class", "wptm-tour-container-"+uniqueId);

            embedTourmake(Settings, options, $scope, startingPov, uniqueId);
        }
    }

    function embedTourmake(Settings, options, $scope, startingPov, uniqueId) {
        var idTour = Settings.getParam("id_tour");

        tour = Tourmake.embed(idTour, $scope.find(".wptm-tour-container-"+uniqueId)[0], options);

        tour.on("load", function (tour, data) {
            var iframe_cont = $scope.find('.wptm-tour-container-'+uniqueId);
            if(iframe_cont.data('scroll') == 1)
            {
                tour.disableScrollWheel();
            }
            if(iframe_cont.data('fullscreen') == 0)
            {
                tour.hideFullscreenControl();
            }
            if(startingPov){
                tour.goto(startingPov);
            }
        });
        return tour;
    }

} )( jQuery );