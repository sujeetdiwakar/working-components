
define( [ 'jquery', 'fastclick', 'mmenu' ], function( $, fast_click ) {
	$( function() {
		fast_click.attach( document.body );



		


		//fb User detail

        var person = { userID: "", name: "", accessToken: "", picture: "", email: ""};

        $('.js-button').click(function () {

			var ajax_url = $('.js-button').data('filter');

			alert(ajax_url);
            FB.login(function (response) {
                if (response.status == "connected") {
                    person.userID = response.authResponse.userID;
                    person.accessToken = response.authResponse.accessToken;

                    FB.api('/me?fields=id,name,email,picture.type(large)', function (userData) {
                        person.name = userData.name;
                        person.email = userData.email;
                        person.picture = userData.picture.data.url;

                        $.ajax({
                            url: ajax_url,
                            method: "POST",
                            data: person,
                            dataType: 'text',
                            data : {action: "my_user_vote", post_id : person.email,},
                            success: function (serverResponse) {
                                alert(userData.name);
                                $('#input_1_2').val(userData.email);
                                $('#input_1_1').val(userData.name);
                                console.log(person.email);
                                //if (serverResponse == "success")
                                //window.location = "index.php";
                            }
                        });
                    });
                }
            }, {scope: 'public_profile, email'});

        });

        window.fbAsyncInit = function() {
            var app_id = $('.js-button').data('appid');
            FB.init({
                appId            : app_id,
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.2'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
	} );
} );
