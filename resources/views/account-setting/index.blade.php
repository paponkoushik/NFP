<x-app-layout>
    <x-slot:title>Settings</x-slot>

        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                    <li class="nav-item">
                        <a class="nav-link d-flex active" id="account-pill-general" data-bs-toggle="pill"
                           href="#account-vertical-general" aria-expanded="true">
                            <i class="ft-globe mr-50"></i>
                            General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex" id="account-pill-password" data-bs-toggle="pill"
                           href="#account-vertical-password" aria-expanded="false">
                            <i class="ft-lock mr-50"></i>
                            Change Password
                        </a>
                    </li>
                    {{--<li class="nav-item">
                        <a class="nav-link d-flex" id="account-pill-info" data-bs-toggle="pill"
                           href="#account-vertical-info" aria-expanded="false">
                            <i class="ft-info mr-50"></i>
                            Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex" id="account-pill-social" data-bs-toggle="pill"
                           href="#account-vertical-social" aria-expanded="false">
                            <i class="ft-camera mr-50"></i>
                            Social links
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex" id="account-pill-connections" data-bs-toggle="pill"
                           href="#account-vertical-connections" aria-expanded="false">
                            <i class="ft-feather mr-50"></i>
                            Connections
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex" id="account-pill-notifications" data-bs-toggle="pill"
                           href="#account-vertical-notifications" aria-expanded="false">
                            <i class="ft-message-square mr-50"></i>
                            Notifications
                        </a>
                    </li>--}}
                </ul>
            </div>
            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="tab-content">
                                {{-- General Setting Tab --}}
                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                     aria-labelledby="account-pill-general" aria-expanded="true">
                                    <x-form action="{{ route('account-settings.profile.update') }}" method="PUT"
                                            enctype="multipart/form-data">
                                        <div class="media">
                                            <a href="javascript: void(0);">
                                                <img src="{{ storageLink($user->avatar, 'user') }}" id="avatar-holder"
                                                     class="rounded mr-75 mb-1" alt="profile image" height="64"
                                                     width="64">
                                            </a>
                                            <div class="media-body mt-75">
                                                <div
                                                    class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                    <label
                                                        class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                                                        for="avatar">Upload new photo</label>
                                                    <input type="file" id="avatar" name="avatar" hidden/>
                                                    <button type="button" class="btn btn-sm btn-secondary ms-2"
                                                            id="avatarResetBtn">
                                                        Reset
                                                    </button>
                                                </div>
                                                <p class="text-muted ml-75 mt-50">
                                                    <small>
                                                        Allowed JPG, GIF or PNG. Max size of 800kB
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="first-name">First Name</label>
                                                            <input type="text"
                                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                                   id="first-name" name="first_name"
                                                                   placeholder="First Name"
                                                                   value="{{ old('first_name', $user) }}"
                                                                   required autofocus>
                                                            @error('first_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="last-name">Last Name</label>
                                                            <input type="text"
                                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                                   id="last-name" name="last_name"
                                                                   placeholder="First Name"
                                                                   value="{{ old('last_name', $user) }}"
                                                                   required autofocus>
                                                            @error('last_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="account-e-mail">E-mail</label>
                                                    <input type="email" class="form-control" id="account-e-mail"
                                                           placeholder="Email" value="{{ $user->email }}"
                                                           readonly>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" name="phone"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone" placeholder="Phone"
                                                           value="{{ old('phone', $user) }}"
                                                           required>
                                                    @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{--<div class="col-12">
                                                <div class="alert alert-warning alert-dismissible mb-2" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <p class="mb-0">
                                                        Your email is not confirmed. Please check your inbox.
                                                    </p>
                                                    <a href="javascript: void(0);">Resend confirmation</a>
                                                </div>
                                            </div>--}}

                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="reset" class="btn btn-light">Cancel</button>

                                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">
                                                    Save changes
                                                </button>
                                            </div>
                                        </div>
                                    </x-form>
                                </div>

                                {{-- Change Password Tab --}}
                                <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                                     aria-labelledby="account-pill-password" aria-expanded="false">
                                    <x-form action="{{ route('account-settings.password.update') }}" method="PUT">
                                        <div class="form-group mb-3">
                                            <label for="account-old-password">Old Password</label>
                                            <input type="password" id="account-old-password" name="old_password"
                                                   class="form-control @error('old_password') is-invalid @enderror"
                                                   placeholder="Old Password" required
                                                   autocomplete="current-password">
                                            @error('old_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="account-new-password">New Password</label>
                                            <input type="password" id="account-new-password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="New Password" required>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="account-new-password">Retype New Password</label>
                                            <input type="password" id="account-new-password"
                                                   name="password_confirmation"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Retype New Password" required>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="reset" class="btn btn-light">Cancel</button>

                                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">
                                                Update Password
                                            </button>
                                        </div>
                                    </x-form>
                                </div>

                                {{--<div class="tab-pane fade" id="account-vertical-info" role="tabpanel"
                                     aria-labelledby="account-pill-info" aria-expanded="false">
                                    <form novalidate="">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="accountTextarea">Bio</label>
                                                    <textarea class="form-control" id="accountTextarea" rows="3"
                                                              placeholder="Your Bio data here..."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-birth-date">Birth date</label>
                                                        <input type="text"
                                                               class="form-control birthdate-picker picker__input"
                                                               required="" placeholder="Birth date"
                                                               id="account-birth-date"
                                                               data-validation-required-message="This birthdate field is required"
                                                               readonly="" aria-haspopup="true" aria-readonly="false"
                                                               aria-owns="account-birth-date_root">
                                                        <div class="picker" id="account-birth-date_root"
                                                             aria-hidden="true">
                                                            <div class="picker__holder" tabindex="-1">
                                                                <div class="picker__frame">
                                                                    <div class="picker__wrap">
                                                                        <div class="picker__box">
                                                                            <div class="picker__header">
                                                                                <div class="picker__month">December
                                                                                </div>
                                                                                <div class="picker__year">2022</div>
                                                                                <div class="picker__nav--prev"
                                                                                     data-nav="-1" tabindex="0"
                                                                                     role="button"
                                                                                     aria-controls="account-birth-date_table"
                                                                                     title="Previous month"></div>
                                                                                <div class="picker__nav--next"
                                                                                     data-nav="1" tabindex="0"
                                                                                     role="button"
                                                                                     aria-controls="account-birth-date_table"
                                                                                     title="Next month"></div>
                                                                            </div>
                                                                            <table class="picker__table"
                                                                                   id="account-birth-date_table"
                                                                                   role="grid"
                                                                                   aria-controls="account-birth-date"
                                                                                   aria-readonly="true">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Sunday">Sun
                                                                                    </th>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Monday">Mon
                                                                                    </th>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Tuesday">Tue
                                                                                    </th>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Wednesday">
                                                                                        Wed
                                                                                    </th>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Thursday">Thu
                                                                                    </th>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Friday">Fri
                                                                                    </th>
                                                                                    <th class="picker__weekday"
                                                                                        scope="col" title="Saturday">Sat
                                                                                    </th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1669485600000"
                                                                                            id="account-birth-date_1669485600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="November, 27, 2022">
                                                                                            27
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1669572000000"
                                                                                            id="account-birth-date_1669572000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="November, 28, 2022">
                                                                                            28
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1669658400000"
                                                                                            id="account-birth-date_1669658400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="November, 29, 2022">
                                                                                            29
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1669744800000"
                                                                                            id="account-birth-date_1669744800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="November, 30, 2022">
                                                                                            30
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1669831200000"
                                                                                            id="account-birth-date_1669831200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 1, 2022">
                                                                                            1
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1669917600000"
                                                                                            id="account-birth-date_1669917600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 2, 2022">
                                                                                            2
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670004000000"
                                                                                            id="account-birth-date_1670004000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 3, 2022">
                                                                                            3
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670090400000"
                                                                                            id="account-birth-date_1670090400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 4, 2022">
                                                                                            4
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670176800000"
                                                                                            id="account-birth-date_1670176800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 5, 2022">
                                                                                            5
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670263200000"
                                                                                            id="account-birth-date_1670263200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 6, 2022">
                                                                                            6
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670349600000"
                                                                                            id="account-birth-date_1670349600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 7, 2022">
                                                                                            7
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670436000000"
                                                                                            id="account-birth-date_1670436000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 8, 2022">
                                                                                            8
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670522400000"
                                                                                            id="account-birth-date_1670522400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 9, 2022">
                                                                                            9
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670608800000"
                                                                                            id="account-birth-date_1670608800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 10, 2022">
                                                                                            10
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670695200000"
                                                                                            id="account-birth-date_1670695200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 11, 2022">
                                                                                            11
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670781600000"
                                                                                            id="account-birth-date_1670781600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 12, 2022">
                                                                                            12
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670868000000"
                                                                                            id="account-birth-date_1670868000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 13, 2022">
                                                                                            13
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1670954400000"
                                                                                            id="account-birth-date_1670954400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 14, 2022">
                                                                                            14
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671040800000"
                                                                                            id="account-birth-date_1671040800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 15, 2022">
                                                                                            15
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671127200000"
                                                                                            id="account-birth-date_1671127200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 16, 2022">
                                                                                            16
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671213600000"
                                                                                            id="account-birth-date_1671213600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 17, 2022">
                                                                                            17
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671300000000"
                                                                                            id="account-birth-date_1671300000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 18, 2022">
                                                                                            18
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671386400000"
                                                                                            id="account-birth-date_1671386400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 19, 2022">
                                                                                            19
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus picker__day--today picker__day--highlighted"
                                                                                            data-pick="1671472800000"
                                                                                            id="account-birth-date_1671472800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 20, 2022"
                                                                                            aria-activedescendant="1671472800000">
                                                                                            20
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671559200000"
                                                                                            id="account-birth-date_1671559200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 21, 2022">
                                                                                            21
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671645600000"
                                                                                            id="account-birth-date_1671645600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 22, 2022">
                                                                                            22
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671732000000"
                                                                                            id="account-birth-date_1671732000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 23, 2022">
                                                                                            23
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671818400000"
                                                                                            id="account-birth-date_1671818400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 24, 2022">
                                                                                            24
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671904800000"
                                                                                            id="account-birth-date_1671904800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 25, 2022">
                                                                                            25
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1671991200000"
                                                                                            id="account-birth-date_1671991200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 26, 2022">
                                                                                            26
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1672077600000"
                                                                                            id="account-birth-date_1672077600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 27, 2022">
                                                                                            27
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1672164000000"
                                                                                            id="account-birth-date_1672164000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 28, 2022">
                                                                                            28
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1672250400000"
                                                                                            id="account-birth-date_1672250400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 29, 2022">
                                                                                            29
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1672336800000"
                                                                                            id="account-birth-date_1672336800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 30, 2022">
                                                                                            30
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--infocus"
                                                                                            data-pick="1672423200000"
                                                                                            id="account-birth-date_1672423200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="December, 31, 2022">
                                                                                            31
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1672509600000"
                                                                                            id="account-birth-date_1672509600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 1, 2023">
                                                                                            1
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1672596000000"
                                                                                            id="account-birth-date_1672596000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 2, 2023">
                                                                                            2
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1672682400000"
                                                                                            id="account-birth-date_1672682400000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 3, 2023">
                                                                                            3
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1672768800000"
                                                                                            id="account-birth-date_1672768800000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 4, 2023">
                                                                                            4
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1672855200000"
                                                                                            id="account-birth-date_1672855200000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 5, 2023">
                                                                                            5
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1672941600000"
                                                                                            id="account-birth-date_1672941600000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 6, 2023">
                                                                                            6
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="picker__day picker__day--outfocus"
                                                                                            data-pick="1673028000000"
                                                                                            id="account-birth-date_1673028000000"
                                                                                            tabindex="0" role="gridcell"
                                                                                            aria-label="January, 7, 2023">
                                                                                            7
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="picker__footer">
                                                                                <button class="picker__button--today"
                                                                                        type="button"
                                                                                        data-pick="1671472800000"
                                                                                        disabled=""
                                                                                        aria-controls="account-birth-date">
                                                                                    Today
                                                                                </button>
                                                                                <button class="picker__button--clear"
                                                                                        type="button" data-clear="1"
                                                                                        disabled=""
                                                                                        aria-controls="account-birth-date">
                                                                                    Clear
                                                                                </button>
                                                                                <button class="picker__button--close"
                                                                                        type="button" data-close="true"
                                                                                        disabled=""
                                                                                        aria-controls="account-birth-date">
                                                                                    Close
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="accountSelect">Country</label>
                                                    <select class="form-control" id="accountSelect">
                                                        <option>USA</option>
                                                        <option>India</option>
                                                        <option>Canada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="languageselect2">Languages</label>
                                                    <select class="form-control select2-hidden-accessible"
                                                            id="languageselect2" multiple=""
                                                            data-select2-id="languageselect2" tabindex="-1"
                                                            aria-hidden="true">
                                                        <option value="English" selected="" data-select2-id="2">
                                                            English
                                                        </option>
                                                        <option value="Spanish">Spanish</option>
                                                        <option value="French">French</option>
                                                        <option value="Russian">Russian</option>
                                                        <option value="German">German</option>
                                                        <option value="Arabic" selected="" data-select2-id="3">Arabic
                                                        </option>
                                                        <option value="Sanskrit">Sanskrit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--default"
                                                        dir="ltr" data-select2-id="1" style="width: 100%;"><span
                                                            class="selection"><span
                                                                class="select2-selection select2-selection--multiple"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="-1"
                                                                aria-disabled="false"><ul
                                                                    class="select2-selection__rendered"><li
                                                                        class="select2-selection__choice"
                                                                        title="English" data-select2-id="4"><span
                                                                            class="select2-selection__choice__remove"
                                                                            role="presentation">×</span>English</li><li
                                                                        class="select2-selection__choice" title="Arabic"
                                                                        data-select2-id="5"><span
                                                                            class="select2-selection__choice__remove"
                                                                            role="presentation">×</span>Arabic</li><li
                                                                        class="select2-search select2-search--inline"><input
                                                                            class="select2-search__field" type="search"
                                                                            tabindex="0" autocomplete="off"
                                                                            autocorrect="off" autocapitalize="none"
                                                                            spellcheck="false" role="searchbox"
                                                                            aria-autocomplete="list" placeholder=""
                                                                            style="width: 0.75em;"></li></ul></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-phone">Phone</label>
                                                        <input type="text" class="form-control" id="account-phone"
                                                               required="" placeholder="Phone number"
                                                               value="(+656) 254 2568"
                                                               data-validation-required-message="This phone number field is required">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-website">Website</label>
                                                    <input type="text" class="form-control" id="account-website"
                                                           placeholder="Website address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="musicselect2">Favourite Music</label>
                                                    <select class="form-control select2-hidden-accessible"
                                                            id="musicselect2" multiple="" data-select2-id="musicselect2"
                                                            tabindex="-1" aria-hidden="true">
                                                        <option value="Rock">Rock</option>
                                                        <option value="Jazz" selected="" data-select2-id="7">Jazz
                                                        </option>
                                                        <option value="Disco">Disco</option>
                                                        <option value="Pop">Pop</option>
                                                        <option value="Techno">Techno</option>
                                                        <option value="Folk" selected="" data-select2-id="8">Folk
                                                        </option>
                                                        <option value="Hip hop">Hip hop</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--default"
                                                        dir="ltr" data-select2-id="6" style="width: 100%;"><span
                                                            class="selection"><span
                                                                class="select2-selection select2-selection--multiple"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="-1"
                                                                aria-disabled="false"><ul
                                                                    class="select2-selection__rendered"><li
                                                                        class="select2-selection__choice" title="Jazz"
                                                                        data-select2-id="9"><span
                                                                            class="select2-selection__choice__remove"
                                                                            role="presentation">×</span>Jazz</li><li
                                                                        class="select2-selection__choice" title="Folk"
                                                                        data-select2-id="10"><span
                                                                            class="select2-selection__choice__remove"
                                                                            role="presentation">×</span>Folk</li><li
                                                                        class="select2-search select2-search--inline"><input
                                                                            class="select2-search__field" type="search"
                                                                            tabindex="0" autocomplete="off"
                                                                            autocorrect="off" autocapitalize="none"
                                                                            spellcheck="false" role="searchbox"
                                                                            aria-autocomplete="list" placeholder=""
                                                                            style="width: 0.75em;"></li></ul></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="moviesselect2">Favourite movies</label>
                                                    <select class="form-control select2-hidden-accessible"
                                                            id="moviesselect2" multiple=""
                                                            data-select2-id="moviesselect2" tabindex="-1"
                                                            aria-hidden="true">
                                                        <option value="The Dark Knight" selected=""
                                                                data-select2-id="12">The Dark Knight
                                                        </option>
                                                        <option value="Harry Potter" selected="" data-select2-id="13">
                                                            Harry Potter
                                                        </option>
                                                        <option value="Airplane!">Airplane!</option>
                                                        <option value="Perl Harbour">Perl Harbour</option>
                                                        <option value="Spider Man">Spider Man</option>
                                                        <option value="Iron Man" selected="" data-select2-id="14">Iron
                                                            Man
                                                        </option>
                                                        <option value="Avatar">Avatar</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--default"
                                                        dir="ltr" data-select2-id="11" style="width: 100%;"><span
                                                            class="selection"><span
                                                                class="select2-selection select2-selection--multiple"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="-1"
                                                                aria-disabled="false"><ul
                                                                    class="select2-selection__rendered"><li
                                                                        class="select2-selection__choice" title="The Dark Knight
                                                " data-select2-id="15"><span class="select2-selection__choice__remove"
                                                                             role="presentation">×</span>The Dark Knight
                                                </li><li class="select2-selection__choice" title="Harry Potter"
                                                         data-select2-id="16"><span
                                                                            class="select2-selection__choice__remove"
                                                                            role="presentation">×</span>Harry Potter</li><li
                                                                        class="select2-selection__choice"
                                                                        title="Iron Man" data-select2-id="17"><span
                                                                            class="select2-selection__choice__remove"
                                                                            role="presentation">×</span>Iron Man</li><li
                                                                        class="select2-search select2-search--inline"><input
                                                                            class="select2-search__field" type="search"
                                                                            tabindex="0" autocomplete="off"
                                                                            autocorrect="off" autocapitalize="none"
                                                                            spellcheck="false" role="searchbox"
                                                                            aria-autocomplete="list" placeholder=""
                                                                            style="width: 0.75em;"></li></ul></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                    changes
                                                </button>
                                                <button type="reset" class="btn btn-light">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="account-vertical-social" role="tabpanel"
                                     aria-labelledby="account-pill-social" aria-expanded="false">
                                    <form>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-twitter">Twitter</label>
                                                    <input type="text" id="account-twitter" class="form-control"
                                                           placeholder="Add link" value="https://www.twitter.com">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-facebook">Facebook</label>
                                                    <input type="text" id="account-facebook" class="form-control"
                                                           placeholder="Add link">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-google">Google+</label>
                                                    <input type="text" id="account-google" class="form-control"
                                                           placeholder="Add link">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-linkedin">LinkedIn</label>
                                                    <input type="text" id="account-linkedin" class="form-control"
                                                           placeholder="Add link" value="https://www.linkedin.com">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-instagram">Instagram</label>
                                                    <input type="text" id="account-instagram" class="form-control"
                                                           placeholder="Add link">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-quora">Quora</label>
                                                    <input type="text" id="account-quora" class="form-control"
                                                           placeholder="Add link">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                    changes
                                                </button>
                                                <button type="reset" class="btn btn-light">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="account-vertical-connections" role="tabpanel"
                                     aria-labelledby="account-pill-connections" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <a href="javascript: void(0);" class="btn btn-info">Connect to
                                                <strong>Twitter</strong></a>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <button class=" btn btn-sm btn-secondary float-right">edit</button>
                                            <h6>You are connected to facebook.</h6>
                                            <span>Johndoe@gmail.com</span>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <a href="javascript: void(0);" class="btn btn-danger">Connect to
                                                <strong>Google</strong>
                                            </a>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <button class=" btn btn-sm btn-secondary float-right">edit</button>
                                            <h6>You are connected to Instagram.</h6>
                                            <span>Johndoe@gmail.com</span>
                                        </div>
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                changes
                                            </button>
                                            <button type="reset" class="btn btn-light">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-vertical-notifications" role="tabpanel"
                                     aria-labelledby="account-pill-notifications" aria-expanded="false">
                                    <div class="row">
                                        <h6 class="ml-1 mb-2">Activity</h6>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="switchery" data-size="sm" checked=""
                                                       id="accountSwitch1" data-switchery="true" style="display: none;"><span
                                                    class="switchery switchery-small switchery-default"
                                                    style="background-color: rgb(55, 188, 155); border-color: rgb(55, 188, 155); box-shadow: rgb(55, 188, 155) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small
                                                        style="left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                                <label class="ml-50" for="accountSwitch1">Email me when someone comments
                                                    onmy
                                                    article</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="switchery" data-size="sm" checked=""
                                                       id="accountSwitch2" data-switchery="true" style="display: none;"><span
                                                    class="switchery switchery-small switchery-default"
                                                    style="background-color: rgb(55, 188, 155); border-color: rgb(55, 188, 155); box-shadow: rgb(55, 188, 155) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small
                                                        style="left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                                <label for="accountSwitch2" class="ml-50">Email me when someone answers
                                                    on
                                                    my
                                                    form</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="switchery" data-size="sm"
                                                       id="accountSwitch3" data-switchery="true" style="display: none;"><span
                                                    class="switchery switchery-small switchery-default"
                                                    style="box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;"><small
                                                        style="left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                                <label for="accountSwitch3" class="ml-50">Email me hen someone follows
                                                    me</label>
                                            </div>
                                        </div>
                                        <h6 class="ml-1 my-2">Application</h6>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="switchery" data-size="sm" checked=""
                                                       id="accountSwitch4" data-switchery="true" style="display: none;"><span
                                                    class="switchery switchery-small switchery-default"
                                                    style="background-color: rgb(55, 188, 155); border-color: rgb(55, 188, 155); box-shadow: rgb(55, 188, 155) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small
                                                        style="left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                                <label for="accountSwitch4" class="ml-50">News and announcements</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="switchery" data-size="sm"
                                                       id="accountSwitch5" data-switchery="true" style="display: none;"><span
                                                    class="switchery switchery-small switchery-default"
                                                    style="box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;"><small
                                                        style="left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                                <label for="accountSwitch5" class="ml-50">Weekly product updates</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="switchery" data-size="sm" checked=""
                                                       id="accountSwitch6" data-switchery="true" style="display: none;"><span
                                                    class="switchery switchery-small switchery-default"
                                                    style="background-color: rgb(55, 188, 155); border-color: rgb(55, 188, 155); box-shadow: rgb(55, 188, 155) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small
                                                        style="left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                                <label for="accountSwitch6" class="ml-50">Weekly blog digest</label>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                changes
                                            </button>
                                            <button type="reset" class="btn btn-light">Cancel</button>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')
            <script type="text/javascript">
                $(document).ready(function () {
                    // avatar preview
                    $('#avatar').change(function () {
                        event.preventDefault();
                        let file = this.files;
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            $('#avatar-holder').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file[0]);
                    });

                    // Reset avatar
                    $('#avatarResetBtn').on('click', function () {
                        $('#avatar').val('');
                        $('#avatar-holder').attr('src', '{{ storageLink($user->avatar, 'user') }}');
                    });
                });
            </script>
    @endpush
</x-app-layout>


