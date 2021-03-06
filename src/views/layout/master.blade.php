<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('../mercadolibre/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('../mercadolibre/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="{{ asset('../mercadolibre/dist/css/timeline.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('../mercadolibre/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="{{ asset('../mercadolibre/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('../mercadolibre/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="wrapper">
      <!-- Navigation -->
      @include('mercadolibre::layout.partials.navigation')
      <div id="page-wrapper">
        @yield('content')
      </div>
      <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('../mercadolibre/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('../mercadolibre/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('../mercadolibre/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('../mercadolibre/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('../mercadolibre/bower_components/morrisjs/morris.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('../mercadolibre/dist/js/sb-admin-2.js') }}"></script>
    @yield('script')
    <script>
    function get_time_diff( datetime ) {
        var datetime = typeof datetime !== 'undefined' ? datetime : "2014-01-01 01:02:03.123456";
        var datetime = new Date( datetime ).getTime();
        var now = new Date().getTime();
        
        if(isNaN(datetime)) {
            return "";
        }
        if (datetime < now) {
            var milisec_diff = now - datetime;
        } else {
            var milisec_diff = datetime - now;
        }
        var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));
        var date_diff = new Date( milisec_diff );

        if(days > 0) {
            return days + " Days ago";
        }

        if(date_diff.getHours() > 0) {
            return date_diff.getHours() + " Hours ago";
        }

        if(date_diff.getMinutes() > 0) {
            return date_diff.getMinutes() + " Minutes ago";
        }
        
        if(date_diff.getSeconds() > 0) {
            return date_diff.getSeconds() + " Seconds ago";
        }
    }
    function LoadFinance() {
        $(function() {
            var html = '';
            $.get( "{{ url('/meli/admin/get_notifications') }}", function(notifications) {
                if(notifications.length) {
                    $.each(notifications, function( k, notification ) {

                        var icon = '<i class="fa fa-comment fa-fw"></i>';
                        var time = notification.received;

                        html += '<li><a href="'+ notification.resource +'">' +
                            '<div>' + icon + ' New Order <span class="pull-right text-muted small">' + get_time_diff(time)  +'</span></div></a></li>'
                            + '<li class="divider"></li>';
                    });
                } else {
                    html = '<li><a href="#"><div>No notifications<span class="pull-right text-muted small"></span></div></a></li>';
                }
                $( "#notifications" ).empty().html( html );
            });
        });
    }

    setInterval( LoadFinance, 30000 );
    </script>
  </body>
</html>