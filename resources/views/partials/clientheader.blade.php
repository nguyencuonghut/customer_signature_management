<div class="col-sm-12">
    <div class="row">

        <h1 class="moveup">{{$client->name}}</h1>

        <!--Client info leftside-->
        <div class="col-sm-4">
            @if($client->primary_number != "")
                <p><span class="glyphicon glyphicon-phone-alt" aria-hidden="true" data-toggle="tooltip"
                         title=" {{ __('Primary Number') }} " data-placement="left"> </span> Điện thoại
                    <a href="tel:{{$client->primary_number}}">
                        <p>{{$client->primary_number}}
                        </p>
                    </a></p>
            @endif
        </div>
        <!--Client info leftside END-->

        <!--Client info rightside-->
        <div class="col-sm-4">
            @if($client->address)
                <p>
                    <span class="glyphicon glyphicon-home" aria-hidden="true" data-toggle="tooltip"
                         title="{{ __('Address') }}" data-placement="left"></span> Địa chỉ
                </p>
                <p>
                    {!! $client->address !!}
                </p>
            @endif
        </div>
        <div class="col-sm-4">
            @if($client->code)
                <p>
                    <span class="glyphicon glyphicon-certificate" aria-hidden="true" data-toggle="tooltip"
                         title="{{ __('Code') }}" data-placement="left"></span> Code
                </p>
                <p>
                    {!! $client->code !!}
                </p>
            @endif
        </div>
        <!--Client info rightside END-->

    </div>
    <br/>
    <div class="row">
        <img src="../upload/{{ $client->signature_path }}" style="margin-left: auto; margin-right: auto; display: block" alt="Signature">
    </div>
</div>
