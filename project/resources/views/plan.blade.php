@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <button type=“button” onclick="location.href='/calendar'">カレンダーに戻る</button>
                <div class="card-body">
                    @foreach($plans as $plan)
                        <!--<h4>{{$plan->id}}</h4>-->
                        <div>
                            <span>{{$plan->date}}</span>
                            <span>{{$plan->todo}}</span>
                        </div>

                        <div style="display:inline-flex">
                            <form action="/edit" method="post">
                              {{ csrf_field() }}
                                    <input type="hidden" name="id":value="{{$plan->id}}">
                                    <input type="text" name="todo" placeholder="予定を入れる">
                                    <input type="submit" value="編集">
                            </form>
                        </div>

                        <div style="display:inline-flex">
                            <form action="/destroy" method="post">
                              {{ csrf_field() }}
                                    <input type="hidden" name="id":value="{{$plan->id}}">
                                    <input type="submit" value="削除">
                            </form>
                        </div>
             
             
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
