@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{{URL::to('/')}}}">MAD 360</a>
@stop



<div class="board">
    <h2 class="sub-title">Score</h2>
    <br><br>
    <div class="row">
        <div class="col-md-12 col-sm-12">

            <h3 class="sub-title text-center">Regions</h3>
            <br>

            <table class="table table-bordered">
                <tr>
                    <th colspan="2" rowspan="2">Region</th>
                    @foreach($verticals as $vertical)
                    <th colspan="2">{{{$vertical->name}}}</th>
                    @endforeach
                </tr>
                <tr>

                    @foreach($verticals as $vertical)
                    @foreach($topics as $topic)
                    <th>{{{substr($topic->subject,0,1)}}}</th>
                    @endforeach
                    @endforeach

                </tr>

                @foreach($regions as $region)
                <tr>
                    <td colspan="2">{{{$region->name}}}</td>





                    @foreach($verticals as $vertical)
                    @foreach($topics as $topic)
                    <?php
                    $region_score = 0;
                    $region_total = 0;
                    $count = 0;
                    ?>
                    @foreach($cities as $city)
                    @if($city->region_id == $region->id)

                    <?php
                                            if(isset($vertical_score[$vertical->id][$city->id][$topic->id]['score']) && $vertical_score[$vertical->id][$city->id][$topic->id]['score'] != 0) {

                    $region_total += $vertical_score[$vertical->id][$city->id][$topic->id]['score'];
                    $count++;
                    $region_score = $region_total/$count;
                    }
                    ?>

                    @endif
                    @endforeach
                    <td>{{{round($region_score,1)}}}</td>
                    @endforeach


                    @endforeach
                </tr>
                @endforeach



            </table>

            <br>

            <h3 class="sub-title text-center">Cities</h3>
            <br>

            <table class="table table-bordered">
                <tr>
                    <th colspan="2" rowspan="2">City</th>
                    @foreach($verticals as $vertical)
                        <th colspan="2">{{{$vertical->name}}}</th>
                    @endforeach
                </tr>
                <tr>

                    @foreach($verticals as $vertical)
                        @foreach($topics as $topic)
                            <th>{{{substr($topic->subject,0,1)}}}</th>
                        @endforeach
                    @endforeach
                    <th>Total</th>
                </tr>


                @foreach($cities as $city)
                    <tr>
                    <td colspan="2">{{{$city->name}}}</td>
                    <?php
                    $city_score = 0;
                    $city_total = 0;
                    $count = 0;
                    ?>
                    @foreach($verticals as $vertical)
                        @foreach($topics as $topic)
                            @if(isset($vertical_score[$vertical->id][$city->id][$topic->id]['score']))
                                <td>{{{round($vertical_score[$vertical->id][$city->id][$topic->id]['score'],1)}}}</td>
                                <?php
                                if($vertical_score[$vertical->id][$city->id][$topic->id]['score'] != 0) {
                                    $city_total += $vertical_score[$vertical->id][$city->id][$topic->id]['score'];
                                    $count++;
                                    $city_score = $city_total/$count;
                                }
                                ?>
                            @else
                                <td></td>
                            @endif
                        @endforeach
                    @endforeach
                        <td>{{{round($city_score,1)}}}</td>
                    </tr>
                @endforeach



            </table>



        </div>
    </div>
</div>

@stop