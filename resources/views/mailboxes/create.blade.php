@extends('layouts.app')

@section('title', __('New Mailbox'))

@section('content')
<div class="container">
	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	        <div class="panel panel-default panel-wizard">
	            <div class="panel-body">
	            	<div class="wizard-header">
		            	<h1>{{ __('Create a mailbox') }}</h1>
		            	<p>
		            		{{ __('Customers email this address for help (e.g. support@domain.com)') }}
		            	</p>
		            </div>
		            <div class="wizard-body">
					 	@include('partials/flash_messages')

					   
					        <div class="row">
					            <div class="col-xs-12">
					                <form class="form-horizontal margin-top" method="POST" action="">
					                    {{ csrf_field() }}

					                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					                        <label for="email" class="col-sm-4 control-label">{{ __('Email Address') }}</label>

					                        <div class="col-md-6">
					                            <input id="email" type="email" class="form-control input-sized" name="email" value="{{ old('email') }}" maxlength="128" required autofocus>
					                            @include('partials/field_error', ['field'=>'email'])
					                        </div>

				                            <div class="col-sm-offset-4 col-md-6">
				                            	<p class="help-block margin-bottom-0">{{ __('You can edit this later') }}</p>
				                            </div>
					                    </div>

					                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					                        <label for="name" class="col-sm-4 control-label">{{ __('Mailbox Name') }}</label>

					                        <div class="col-md-6">
					                            <input id="name" type="text" class="form-control input-sized" name="name" value="{{ old('name') }}" maxlength="40" required autofocus>

					                            @include('partials/field_error', ['field'=>'name'])
					                        </div>
					                    </div>

					                    <div class="form-group{{ $errors->has('ratings') ? ' has-error' : '' }}">
					                        <label for="ratings" class="col-sm-4 control-label">{{ __('Satisfaction Ratings') }}</label>

					                        <div class="col-md-6">
					                            <select id="ratings" class="form-control input-sized" name="ratings" required autofocus>
					                                <option value="1" @if ((int)old('ratings'))selected="selected"@endif>{{ __('On') }}</option>
					                                <option value="0" @if ((int)old('ratings'))selected="selected"@endif>{{ __('Off') }}</option>
					                            </select>

					                            @include('partials/field_error', ['field'=>'ratings'])
					                        </div>
					                    </div>

					                    <div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
					                        <label for="users" class="col-sm-4 control-label">{{ __('Who Else Will Use This Mailbox') }}</label>

					                        <div class="col-md-6">
					                            <p class="existing">
					                            	<a href="javascript:void(0)" class="selAll">{{ __('all') }}</a> / <a href="javascript:void(0)" class="selNone">{{ __('none') }}</a>
					                            </p>

					                            @include('partials/field_error', ['field'=>'users'])
					                        </div>
					                    </div>

					                    <div class="form-group">
					                        <div class="col-md-6 col-sm-offset-4">
					                            <button type="submit" class="btn btn-primary">
					                                {{ __('Create Mailbox') }}
					                            </button>
					                        </div>
					                    </div>

					                </form>
					            </div>
					        </div>
					    
	                </div>
	                <div class="wizard-footer">
	                	
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
