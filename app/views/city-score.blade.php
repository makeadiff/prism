@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{{URL::to('/')}}}">MAD 360</a>
@stop




<div class="board">
    <h2 class="sub-title">City Scores</h2>
    <br><br>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row">
            <table data-page-size="100" class="table table-bordered table-responsive footable ">
                <thead>
                <tr>
                    <th>Name</th><th data-type="numeric">Reliability</th><th data-type="numeric">Level of Involvement</th><th data-type="numeric">Honoring the word</th>
                    <th data-type="numeric">Proactive Communication</th><th data-type="numeric">Humility</th><th data-type="numeric">Level Headedness</th>
                    <th data-type="numeric">Personal Professional Balance</th><th>Average</th>
                </tr>
                </thead>
                <tbody>

            <?php
            foreach($users as $user){

            $scores = User::getAnswers($user->id);
                if(!empty($scores)){

                    echo "<tr><td>$user->name</td>";
                    $sum = 0;
                    $count = 0;

                    foreach($scores as $score) {



                        echo  "<td>$score->level</td>";
                        $sum += $score->level;
                        $count++;
                    }

                    echo "<td>" . round($sum/$count,1) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

@stop