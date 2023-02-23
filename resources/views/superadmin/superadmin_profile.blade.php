@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="container-full">

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        {{-- @dd($user) --}}
                        <div class="widget-user-header bg-vq">
                          <h3 class="widget-user-username">{{__('Name')}}: {{$user->firstName}} {{$user->surName}}</h3>

                        <a href="javascript:" data-param=""
                        data-url="{{ route('superadmin.user.edit', $user->id) }}"
                        title="{{__('Edit')}}"
                        class="load-popup d-none float-right btn btn-rounded btn-outline-light mt-1"
                        style="position: absolute;right: 13px;top: 10px; padding:2px 4px!important">
                        <i class="fa fa-edit"></i></a>

                          {{-- <h6 class="widget-user-desc">User Type : {{$user->usertype}}</h6> --}}
                          <h6 class="widget-user-desc">{{__('Role')}} : {{__('SuperAdmin')}}</h6>
                         </div>
                        <div class="widget-user-image">
                          <img class="rounded-circle"
                          src="{{ (!empty($user->image)? url('upload/user_images/'.$user->image) :url('upload/no_image.jpg') )}}"
                          alt="User Avatar">
                        </div>
                        <div class="box-footer">
                          <div class="row">
                            <div class="col-sm-4 ">
                                <div class="description-block">
                                    <h5 class="description-header">{{__('Email')}}</h5>
                                    <span class="">{{$user->email}}</span>
                                  </div>

                                <!-- /.description-block -->
                              </div>
                            <div class="col-sm-4 br-1 bl-1">
                                <div class="description-block">
                                    <h5 class="description-header">{{__('Phone No')}}</h5>
                                    <span class="description-text">{{ $user->phoneNumber}}</span>
                                  </div>

                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->

                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{__('Status')}}</h5>
                                    <span class="description-text">{{ __('ACTIVE')}}</span>
                                  </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                      </div>
                </div>
            </div>


        </section>
    </div>


</div>
@endsection
