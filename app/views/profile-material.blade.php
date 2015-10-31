<html>
<head>
    <title>Backathon</title>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/custom.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('head')
</head>

<body>
<nav>
    <div class="nav-wrapper">
        <a href="{{URL::to('/')}}" class="brand-logo">Growth Project</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="">About</a></li>
            <li><a href=""><i class="material-icons right">power_settings_new</i>Logout</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="">About</a></li>
            <li><a href="">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col s12 offset-m2 m8 offset-l2 l8">

            <h4 class="center-align">{{$user->name}}'s Profile</h4>

            <ul class="tabs">
                <li class="tab col s3 {{$tab['managee']['active']}}"><a class="{{$tab['managee']['active']}}" href="#review-managee">Manager</a></li>
                <li class="tab col s3 {{$tab['manager']['active']}}"><a class="{{$tab['manager']['active']}}" href="#review-manager">Managee</a></li>
                <li class="tab col s3 {{$tab['peer']['active']}}"><a class="{{$tab['peer']['active']}}" href="#review-peer">Peer</a></li>
            </ul>

            @foreach($types as $type)

                <div id="review-{{$type}}">
                    <br>
                    <h5 class="center-align">
                        @if($type == 'managee')
                            Your Manager's Review
                        @elseif($type == 'manager')
                            Your Managee's Review
                        @else
                            Your Peer's Review
                        @endif
                    </h5>

                    @foreach($topics as $topic)

                        <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">

                            </div>
                            <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">{{$topic->subject}}<i
                                        class="material-icons right">more_vert</i></span>

                                <div id="chart-{{$type}}-{{str_replace(' ', '-', $topic->subject)}}"></div>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">Card Title<i
                                            class="material-icons right">close</i></span>

                                <p>Here is some more information about this product that is only revealed once clicked
                                    on.</p>
                            </div>
                        </div>

                    @endforeach


                    <ul class="collapsible" data-collapsible="accordion">
                        @foreach($topics as $topic)
                            <?php $questions = $topic->question()->get();?>
                            <li>
                                <div class="collapsible-header"><i
                                            class="material-icons">filter_drama</i>{{$topic->subject}}</div>
                                <div class="collapsible-body box">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Score</th>
                                            <th>Average</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        @foreach($questions as $question)

                                            <tr>
                                                <td>Q. {{$question->subject}} </td>
                                                <td>{{$data[$type][$topic->id][$question->id]['score']}}</td>
                                                <td>{{$data[$type][$topic->id][$question->id]['average']}}</td>
                                                @if(!empty($data[$type][$topic->id][$question->id]['comments']))
                                                    <tr>
                                                        <td colspan="3">
                                                            Comments on {{$question->subject}} : <br>
                                                            @foreach($data[$type][$topic->id][$question->id]['comments'] as $key => $comment)
                                                                {{$key+1}}. {{$comment}}<br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tr>

                                                @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </li>
                        @endforeach

                    </ul>

                </div>

            @endforeach


        </div>
    </div>
</div>
</div>
<script src="{{URL::to('/')}}/js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script src="{{URL::to('/')}}/js/highcharts.js"></script>
<script>
    var chart_data = <?php echo json_encode($data)?>;
    var user_type = '<?php if($user->getUserType() == 'national')
                                echo 'bro';
                            else
                                echo $user->getUserType() ?>';
</script>
<script src="{{URL::to('/')}}/js/custom.js"></script>

</body>
</html>

