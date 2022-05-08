@extends('pages.home')
@push('css_before')
@endpush

@section('title', 'Documentation')
@section('left-content')
@include('pages.left-menu-items')
@stop
@section('right-content')
    <div class="block">
        <div class="block-header block-header-default">
            <div class="block-title fs-xs">API Documentation</div>
        </div>
        <div class="block-content fs-xs">
            <div class="title">GETTING STARTED</div>
            <hr>
            <div>
                Start Building with Ngata Homes Africa provides a secure way to send disbursement list to the partners
                (Mwanga Hakika Bank).
                Create an account or login using your existing credentials. If you don't have an account then do
                registration.
                Then use your keys to explore Ngata Homes Africa's integration solutions.
            </div><br>
            <div>
                <b>Understanding account credentials</b><br>
                Account credentials are available in your dashboard for both staging and production environment. <br>
                <b>Remember:</b> Never share your application key or secret with other developers or anyone unauthorised will compromise the security of your application. <br>
                <b>Documentation</b> <br>
                Read the instructions about how to effectively use and integrate with an API.
            </div>
            <hr>
            <div class="title">AUTHORIZATION</div>
            <hr>
            <div><b>Base URLs:</b></div>
            <div class="p-2 text-white" style="background: #00314a; border-radius: 5px">
                <b><span style="color: #ffce00">POST --</span> http://openapi.ngata.co.tz/request/authorization</b><!--<hr><b><span style="color: #ffce00">POST --</span> https://openapi.ngata.co.tz/request/authorization</b>-->
            </div>
            <div class="pt-2">This API is used to get the bearer token. The output of this API contains access_token that will be used as bearer token for the API that we will be going to call.</div>
            <div class="pt-3">HEADER PARAMETERS</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Accept</code></div>
                <div class="col-md-3 col-sm-6">application/json</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Authorization</code></div>
                <div class="col-md-4 col-sm-6">Bearer < api key ></div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Content-Type</code></div>
                <div class="col-md-4 col-sm-6">text/xml</div>
            </div><hr>


            <div class="">REQUEST BODY</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-3 col-sm-4 fw-bold">VALUES</div>
                <div class="col-md-4 col-sm-4 fw-bold">REQUIRED</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>clientID</code></div>
                <div class="col-md-3 col-sm-4">Encrypted client ID</div>
                <div class="col-md-3 col-sm-4">True</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>client_secret</code></div>
                <div class="col-md-3 col-sm-4">Encrypted client secret key</div>
                <div class="col-md-3 col-sm-4">True</div>
            </div>  <br>
            <div><img src="{{asset('image/oauth-req-body.PNG')}}" class="img-fluid" style="height: ;"></div><hr>


            <div class="">RESPONSE - <code>SUCCESS RESPONSE</code></div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-3 col-sm-4 fw-bold">VALUES</div>
                <div class="col-md-6 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>status_code</code></div>
                <div class="col-md-3 col-sm-4">NHA305</div>
                <div class="col-md-6 col-sm-4">NHA305 - {{_geterror_code('NHA305')}}.</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>message</code></div>
                <div class="col-md-3 col-sm-4">Authorized</div>
                <div class="col-md-6 col-sm-4">It explains the meaning of status code .</div>
            </div>  
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>token_timeout</code></div>
                <div class="col-md-3 col-sm-4">120</div>
                <div class="col-md-6 col-sm-4">Token will be valid only for 120 seconds.</div>
            </div> 

            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>token</code></div>
                <div class="col-md-3 col-sm-4">string</div>
                <div class="col-md-6 col-sm-4">Used to authenticate the request from clients</div>
            </div> 
            <br>
            <div><img src="{{asset('image/oauth-res-body.PNG')}}" class="img-fluid" style="height: ;"></div><hr>


            {{-- RESPONSE BODY -- ERROR RESPONSE --}}
            <div class="">RESPONSE - <code>ERROR RESPONSE</code></div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-3 col-sm-4 fw-bold">VALUES</div>
                <div class="col-md-6 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>status_code</code></div>
                <div class="col-md-3 col-sm-4">NHA500</div>
                <div class="col-md-6 col-sm-4">NHA500 - client failed to be authorized.</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>message</code></div>
                <div class="col-md-3 col-sm-4">{{_geterror_code('NHA500')}}</div>
                <div class="col-md-6 col-sm-4">It explains the meaning of status code .</div>
            </div>
            <br>
            <div><img src="{{asset('image/oauth-res-err-body.PNG')}}" class="img-fluid" style="height: ;"></div>

            <div class="pt-3">ENCRYPTION OF THE KEYS</div><hr>
            <a href="{{route('download')}}">DOWNLOAD RSA_Crypt.zip</a>
            <div>In order to get a bearer token, you supposed to encrypt your keys using <b>RSA_Crypt algorithm</b>. The algorithm uses two keys i.e Public key and Private key, public key is usually used for encryption of the plain text to cipher text 
            while a private used to decrypt the cipher text to plain text. Use the public key provided in <u>RSA_Crypt.zip</u> to encrypt your <u>CLIENT ID</u> and <u>CLIENT SECRET KEY</u>, then use the encrypted keys to send request to acquire the bearer token</div>

            {{-- REQUEST FOR PENDING DISBURSEMENT  --}}
            <hr>
            <div class="title">PENDING PAYMENT API</div>
            <hr>
            <div><b>Base URLs:</b></div>
            <div class="p-2 text-white" style="background: #00314a; border-radius: 5px">
                <b><span style="color: #ffce00">POST --</span> http://openapi.ngata.co.tz/request/pending-disbursements</b><!--<hr><b><span style="color: #ffce00">POST --</span> https://openapi.ngata.co.tz/request/authorization</b>-->
            </div>
            <div class="pt-2">This API is used to get pending disbursements.</div>
            <div class="pt-3">HEADER PARAMETERS</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Accept</code></div>
                <div class="col-md-3 col-sm-6">application/json</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Authorization</code></div>
                <div class="col-md-4 col-sm-6">Bearer < authorized token ></div>
            </div><hr>


            {{-- RESPONSE BODY -- PENDING DISBURSEMENT --}}
            <div class="">RESPONSE - <code>PENDING DISBURSEMENT</code></div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-5 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>conversation_id</code></div>
                <div class="col-md-5 col-sm-4">It useful for payment acknoledgement</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>source_account</code></div>
                <div class="col-md-5 col-sm-4">Collection account</div>
            </div>  
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>status_description</code></div>
                <div class="col-md-5 col-sm-4">Disbursement request success.</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>status_code</code></div>
                <div class="col-md-5 col-sm-4">NHA304 Means Disbursement request success.</div>
            </div> 
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>amount</code></div>
                <div class="col-md-5 col-sm-4">Total amount to be disurbed</div>
            </div> 
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>payments > payment > destination_account</code></div>
                <div class="col-md-5 col-sm-4">Account for receiving commision</div>
            </div> 
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>payments > payment > currency_code</code></div>
                <div class="col-md-5 col-sm-4">Country code eg TZ, UG, KE</div>
            </div> 

            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>payments > payment > amount_to_disburse</code></div>
                <div class="col-md-5 col-sm-4">amount to disburse.</div>
            </div> 
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>payments > payment > narration</code></div>
                <div class="col-md-5 col-sm-4">Transaction description</div>
            </div> 
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>payments > payment > transaction_commision</code></div>
                <div class="col-md-5 col-sm-4"></div>
            </div> 
            <br>
            <div><img src="{{asset('image/pnd-dis.PNG')}}" class="img-fluidd" style="height: ;"></div><hr>


            {{-- RESPONSE BODY -- NO PENDING DISBURSEMENT --}}
            <div class="">RESPONSE - <code>NO PENDING DISBURSEMENT</code></div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-6 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>status_code</code></div>
                <div class="col-md-6 col-sm-4">NHA505 - {{_geterror_code('NHA505')}}</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>message</code></div>
                <div class="col-md-3 col-sm-4">{{_geterror_code('NHA505')}}</div>
            </div>
            <br>
            <div><img src="{{asset('image/no-pnd-dis.PNG')}}" class="img-fluid" style="height: ;"></div>
            <hr>
            <div class="title">PENDING PAYMENT ACKNOWLEDGEMENT API</div>
            <hr>
            <div><b>Base URLs:</b></div>
            <div class="p-2 text-white" style="background: #00314a; border-radius: 5px">
                <b><span style="color: #ffce00">POST --</span> http://openapi.ngata.co.tz/request/alpha-feedback</b><!--<hr><b><span style="color: #ffce00">POST --</span> https://openapi.ngata.co.tz/request/authorization</b>-->
            </div>
            <div class="pt-2">This API is used to acknowledge the succesfully pending disbursements as received to the end point.</div>
            <div class="pt-3">HEADER PARAMETERS</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Accept</code></div>
                <div class="col-md-3 col-sm-6">application/json</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Content-Type</code></div>
                <div class="col-md-3 col-sm-6">text/xml</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Authorization</code></div>
                <div class="col-md-4 col-sm-6">Bearer < authorized token ></div>
            </div><hr>



            <div class="">REQUEST BODY</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-3 col-sm-4 fw-bold">VALUES</div>
                <div class="col-md-4 col-sm-4 fw-bold">REQUIRED</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>status_code</code></div>
                <div class="col-md-3 col-sm-4">NHA300</div>
                <div class="col-md-3 col-sm-4">True</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>message</code></div>
                <div class="col-md-3 col-sm-4">{{_geterror_code('NHA300')}}</div>
                <div class="col-md-3 col-sm-4">Optional</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>conversation_id</code></div>
                <div class="col-md-3 col-sm-4">Conversation ID received</div>
                <div class="col-md-3 col-sm-4">True</div>
            </div>  
            <br>
            <div><img src="{{asset('image/alpha-req.PNG')}}" class="img-fluid" style="height: ;"></div><hr>

            <div class="">RESPONSE - <code>SUCCESS</code></div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-5 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>status_code</code></div>
                <div class="col-md-5 col-sm-4">NHA301 Means payment acknowledged as received</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>message</code></div>
                <div class="col-md-5 col-sm-4">Payment acknowledged as received</div>
            </div> 
            <div><img src="{{asset('image/alpha-res.PNG')}}" class="img-fluid" style="height: ;"></div><hr> 
            
            
            <div class="">RESPONSE - <code>ERROR</code></div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-5 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>status_code</code></div>
                <div class="col-md-5 col-sm-4">NHA502 - {{_geterror_code('NHA301')}}</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>message</code></div>
                <div class="col-md-5 col-sm-4">{{_geterror_code('NHA301')}}</div>
            </div> 
            <div><img src="{{asset('image/alpha-res-err.PNG')}}" class="img-fluid" style="height: ;"></div><hr> 




            <div class="title">PENDING PAYMENT ACKNOWLEDGEMENT API</div>
            <hr>
            <div><b>Base URLs:</b></div>
            <div class="p-2 text-white" style="background: #00314a; border-radius: 5px">
                <b><span style="color: #ffce00">POST --</span> http://openapi.ngata.co.tz/request/payment-feedback</b><!--<hr><b><span style="color: #ffce00">POST --</span> https://openapi.ngata.co.tz/request/authorization</b>-->
            </div>
            <div class="pt-2">This API is used to acknowledge the succesfully paid disbursements.</div>
            <div class="pt-3">HEADER PARAMETERS</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Accept</code></div>
                <div class="col-md-3 col-sm-6">application/json</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Content-Type</code></div>
                <div class="col-md-3 col-sm-6">text/xml</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-6"><code>Authorization</code></div>
                <div class="col-md-4 col-sm-6">Bearer < authorized token ></div>
            </div><hr>



            <div class="">REQUEST BODY</div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-3 col-sm-4 fw-bold">VALUES</div>
                <div class="col-md-4 col-sm-4 fw-bold">REQUIRED</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>status_code</code></div>
                <div class="col-md-3 col-sm-4">NHA303</div>
                <div class="col-md-3 col-sm-4">True</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>message</code></div>
                <div class="col-md-3 col-sm-4">{{_geterror_code('NHA303')}}</div>
                <div class="col-md-3 col-sm-4">Optional</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-3 col-sm-4"><code>conversation_id</code></div>
                <div class="col-md-3 col-sm-4">Conversation ID received</div>
                <div class="col-md-3 col-sm-4">True</div>
            </div>  
            <br>
            <div><img src="{{asset('image/beta-req.PNG')}}" class="img-fluid" style="height: ;"></div><hr>

            <div class="">RESPONSE - <code>SUCCESS</code></div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-5 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>status_code</code></div>
                <div class="col-md-5 col-sm-4">NHA302 - {{_geterror_code('NHA302')}}</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>message</code></div>
                <div class="col-md-5 col-sm-4">{{_geterror_code('NHA302')}}</div>
            </div> 
            <div><img src="{{asset('image/beta-res.PNG')}}" class="img-fluid" style="height: ;"></div><hr> 



            <div class="">RESPONSE - <code>ERROR</code></div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4 fw-bold">ATTRIBUTES</div>
                <div class="col-md-5 col-sm-4 fw-bold">DESCRIPTION</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>status_code</code></div>
                <div class="col-md-5 col-sm-4">NHA502 - {{_geterror_code('NHA301')}}</div>
            </div>
            <div class="row pt-1">
                <div class="col-md-4 col-sm-4"><code>message</code></div>
                <div class="col-md-5 col-sm-4">{{_geterror_code('NHA301')}}</div>
            </div> 
            <div><img src="{{asset('image/alpha-res-err.PNG')}}" class="img-fluid" style="height: ;"></div><hr>


            ERROR CODES
            <hr>
            <div class="row pt-1">
                <div class="col-md-2 col-sm-6 fw-bold">CODE</div>
                <div class="col-md-10 col-sm-6 fw-bold">DESCRIPTION</div>
            </div>
            @foreach (_error_code() as $key => $row)   
                <div class="row pt-1 ">
                    <div class="col-md-2 col-sm-6">{{$key}}</div>
                    <div class="col-md-10 col-sm-6">{{$row}}</div>
                </div>
            @endforeach
            <br>
        </div>
    </div>
@stop

@push('js_after')
@endpush
