<html>
<head>
    <title>Backathon</title>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{URL::to('/')}}/css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('/')}}/css/custom.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('head')
</head>

<body>
<nav>
    <div class="nav-wrapper color-dark-primary">
        <a href="{{URL::to('/')}}" class="brand-logo ">&nbsp;Growth Project</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{URL::to('/logout')}}"><i class="material-icons right">power_settings_new</i>Logout</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="{{URL::to('/logout')}}">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">

        <div class="col s12 offset-m2 m8 offset-l2 l8">
            <br>
            <h4 class="center-align">{{$user->name}}'s Profile</h4>


            <br>
            <ul class="tabs ">
                <li class="tab col s3 {{$tab['managee']['disabled']}}"><a class="{{$tab['managee']['active']}}" href="#review-managee">Manager</a></li>
                <li class="tab col s3 {{$tab['manager']['disabled']}}"><a class="{{$tab['manager']['active']}}" href="#review-manager">Managee</a></li>
                <li class="tab col s3 {{$tab['peer']['disabled']}}"><a class="{{$tab['peer']['active']}}" href="#review-peer">Peer</a></li>
            </ul>

            @foreach($types as $type)

                <div id="review-{{$type}}">
                    <br>
                    <h5 class="center-align">
                        @if($type == 'managee')
                            Review by Managees
                        @elseif($type == 'manager')
                            Review by Managers
                        @else
                            Review by Peers
                        @endif
                    </h5>
                    <div class="underline"></div>
                    <br>

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
                                <span class="card-title grey-text text-darken-4">{{$topic->subject}}<i
                                            class="material-icons right">close</i></span>

                                @if($topic->subject == "Integrity")
                                    <p>To learn more about Integrity check the following : </p>
                                    <a target="_blank" href="resources/Integrity: Without it Nothing Works.pdf">Integrity: Without it Nothing Works (Interview) (SSRN)</a><br>
                                    <a target="_blank" href="http://papers.ssrn.com/sol3/papers.cfm?abstract_id=1542759">Integrity: A Positive Model (Research Paper) (SSRN)</a><br>
                                    <a target="_blank" href="https://docs.google.com/presentation/d/1UgQdAw5dpsXvtkNBMbSxHi63hOyBFfP3qrzNX4qfyYg/edit#slide=id.g5226a6a56_0_31">Integrity: LC Presentation</a><br>
                                @else
                                    <p>To learn more about Team Work check the following : </p>
                                    <a target="_blank" href="https://www.youtube.com/watch?v=xTkKSJSqU-I">David Logan on Tribal leadership (TedX) (YouTube)</a><br>
                                    <a target="_blank" href="https://www.youtube.com/watch?v=ReRcHdeUG9Y">Simon Sine on Why Leaders Eat Last (YouTube)</a><br>
                                    <a target="_blank" href="http://www.wikihow.com/Practice-Nonviolent-Communication">How to Practice Non Violent Communication</a>
                                @endif
                            </div>
                        </div>

                    @endforeach

                    <br>

                    <ul class="collapsible" data-collapsible="accordion">
                        @foreach($topics as $topic)
                            <?php $questions = $topic->question()->get();?>
                            <li>
                                <div class="collapsible-header"><i
                                            class="material-icons">list</i>{{$topic->subject}}</div>
                                <div class="collapsible-body box">
                                    <table class="heat-map">
                                        <thead>
                                        <tr>
                                            <th class="first">Question</th>
                                            <th>Your Rating</th>
                                            <th class="last">Average</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        @foreach($questions as $question)

                                            <tr class="stats-row">
                                                <td class="stats-title">Q. {{$question->subject}} </td>
                                                <td>{{$data[$type][$topic->id][$question->id]['score']}}</td>
                                                <td>{{$data[$type][$topic->id][$question->id]['average']}}</td>
                                                @if(!empty($data[$type][$topic->id][$question->id]['comments']))
                                                    <tr>
                                                        <td colspan="3" class="stats-title">
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

            <br>
            <h5 class="center-align">
                {{$user->city()->first()->name}}'s Happiness Index
            </h5>
            <div class="underline"></div>
            <br>

            <div id="hi">
                <div class="card">
                    <div class="card-content white-text">
                        <table class="heat-map">
                            <thead>
                            <tr>
                                <th class="first">
                                    Question
                                </th>
                                <th>
                                    City average
                                </th>
                                <th class="last">
                                    National average
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($hi_questions as $question)
                                    <tr class="stats-row">
                                        <td class="stats-title">
                                            {{$question->question}}
                                        </td>
                                        <td>
                                            {{$hi_city_data[$question->id]['aggregate_level']}}
                                        </td>
                                        <td>
                                            {{$hi_national_data[$question->id]['aggregate_level']}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="border_top">
                                    <td class="stats-title">
                                        Total Responders
                                    </td>
                                    <td class="stats-title">
                                        {{$hi_city_data[1]['total_answer_count']}}
                                    </td>
                                    <td class="stats-title">
                                        {{$hi_national_data[1]['total_answer_count']}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</div>
<script src="{{URL::to('/')}}/js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/materialize.min.js"></script>
<script src="{{URL::to('/')}}/js/highcharts.js"></script>
<script>
    var chart_data = <?php echo json_encode($data)?>;
    var user_type = '<?php if($user->getUserType() == 'national')
                                echo 'bro';
                            else if($user->getUserType() == 'fellow')
                                echo 'multiplier';
                            else
                                echo $user->getUserType() ?>';
    var percentile_strings = <?php echo json_encode($percentile_strings)?>;
</script>
<script src="{{URL::to('/')}}/js/custom.js"></script>

</body>
</html>

