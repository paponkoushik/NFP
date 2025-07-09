<x-app-layout>
    <div class="row">
        <x-slot:title>Messages</x-slot>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="align-content-center d-flex justify-content-between mb-3">
                        <a href="#" class="text-success hover:text-sky-600">
                            <i class="bx bx-chevron-left fs-3"></i>
                            <span >All Messages</span>
                        </a>

                        <span class="fs-5 fw-normal">Messages</span>

                        <div>
                            <span class="pe-3 border-end"><i class="bx bx-flag align-top"></i> Report</span>
                            <span class="ps-3 hover:text-red-600"><i class="bx bx-trash align-top"></i> Delete</span>
                        </div>
                    </div>

                    <div class="chat-box">
                        <div class="people-list rounded-start" id="people-list">
                            <div class="search">
                                <input type="text" class="form-control rounded-pill" placeholder="search" />
                            </div>
                            <ul class="list list-unstyled">
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">James Porter</div>
                                        <div class="status"><i class="fa fa-circle online"></i> online</div>
                                    </div>
                                </li>
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_02.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Aiden Chavez</div>
                                        <div class="status"><i class="fa fa-circle offline"></i> left 7 mins ago</div>
                                    </div>
                                </li>
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_03.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Mike Thomas</div>
                                        <div class="status"><i class="fa fa-circle online"></i> online</div>
                                    </div>
                                </li>
                    
                                {{-- <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_04.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Erica Hughes</div>
                                        <div class="status"><i class="fa fa-circle online"></i> online</div>
                                    </div>
                                </li>
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_05.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Ginger Johnston</div>
                                        <div class="status"><i class="fa fa-circle online"></i> online</div>
                                    </div>
                                </li>
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_06.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Tracy Carpenter</div>
                                        <div class="status"><i class="fa fa-circle offline"></i> left 30 mins ago</div>
                                    </div>
                                </li> --}}
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_07.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Christian Kelly</div>
                                        <div class="status"><i class="fa fa-circle offline"></i> left 10 hours ago</div>
                                    </div>
                                </li>
                    
                                {{-- <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_08.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Monica Ward</div>
                                        <div class="status"><i class="fa fa-circle online"></i> online</div>
                                    </div>
                                </li>
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_09.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Dean Henry</div>
                                        <div class="status"><i class="fa fa-circle offline"></i> offline</div>
                                    </div>
                                </li>
                    
                                <li class="clearfix">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_10.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Peyton Mckinney</div>
                                        <div class="status"><i class="fa fa-circle online"></i> online</div>
                                    </div>
                                </li> --}}
                            </ul>
                        </div>
                    
                        @php 
                            $titles = [
                                'Collaborate with another charity that delivers services to adults with disabilities',
                                'Merge with another not for profit organisation',
                                'Selling a For profit osteopathic services business'
                            ];

                            $images = [
                                ['example-1-1.jpg', 'example-1-2.jpg'],
                                ['example-2-1.jpg', 'example-2-2.jpg'],
                                ['example-3-1.jpg', 'example-3-2.jpg']
                            ][rand(0, 2)];
                        @endphp
                        <div class="chat pb-3">
                            <div class="chat-header clearfix d-flex justify-content-between pe-0 ps-3">
                                {{-- <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg" alt="avatar" />
                    
                                <div class="chat-about">
                                    <div class="chat-with">Conversation with James Smith</div>
                                    <div class="chat-num-messages">already 5 messages</div>
                                </div>
                                <i class="fa fa-star"></i> --}}
                                <div class="d-flex justify-content-start align-items-center w-25">
                                    <div class="avatar avatar-md me-2">
                                        <span class="avatar-initial rounded-circle bg-label-warning">STL</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-truncate">Tanvir Gaus</h6>
                                        <small class="text-truncate text-muted">Smart-catalog Tech Ltd.</small>
                                    </div>
                                </div>

                                <div class="align-items-center d-flex justify-content-end px-3 w-75">
                                    <a href="/posts/1/show" class="text-body">
                                        <div class="d-flex flex-column hover:text-emerald-600">
                                            <span class="fw-normal lh-1">{{ $titles[rand(0,2)] }}</span>
                                            <small class="text-end">
                                                <span class="badge bg-label-success fs-6">$1,000,000.00</span>
                                            </small>
                                        </div>
                                    </a>

                                    <div class="avatar avatar-md ms-2">
                                        <img src="{{ asset('assets/img/backgrounds/' . $images[rand(0,1)]) }}" alt="Avatar" class="rounded">
                                    </div>
                                </div>
                            </div>
                            <!-- end chat-header -->
                    
                            <div class="chat-history">
                                <ul class="list-unstyled">
                                    <li class="clearfix">
                                        <div class="message-data align-right"><span class="message-data-time">10:10 AM, Today</span> &nbsp; &nbsp; <span class="message-data-name">Olia (Case Manager)</span> <i class="fa fa-circle me"></i></div>
                                        <div class="message other-message float-right">
                                            Hi James, how are you? How is the project coming along?
                                        </div>
                                    </li>
                    
                                    <li>
                                        <div class="message-data">
                                            <span class="message-data-name"><i class="fa fa-circle online"></i> James (Client)</span>
                                            <span class="message-data-time">10:12 AM, Today</span>
                                        </div>
                                        <div class="message my-message">
                                            Are we meeting today? Project has been already finished and I have results to show you.
                                        </div>
                                    </li>
                    
                                    <li class="clearfix">
                                        <div class="message-data align-right"><span class="message-data-time">10:14 AM, Today</span> &nbsp; &nbsp; <span class="message-data-name">Olia (Case Manager)</span> <i class="fa fa-circle me"></i></div>
                                        <div class="message other-message float-right">
                                            Well I am not sure. The rest of the team is not here yet. Maybe in an hour or so? Have you faced any problems at the last phase of the project?
                                        </div>
                                    </li>
                    
                                    <li>
                                        <div class="message-data">
                                            <span class="message-data-name"><i class="fa fa-circle online"></i> James (Client)</span>
                                            <span class="message-data-time">10:20 AM, Today</span>
                                        </div>
                                        <div class="message my-message">
                                            Actually everything was fine. I'm very excited to show this to our team.
                                        </div>
                                    </li>
                    
                                    <li>
                                        <div class="message-data">
                                            <span class="message-data-name"><i class="fa fa-circle online"></i> James (Client)</span>
                                            <span class="message-data-time">10:31 AM, Today</span>
                                        </div>
                                        <i class="fa fa-circle online"></i>
                                        <i class="fa fa-circle online" style="color: #aed2a6;"></i>
                                        <i class="fa fa-circle online" style="color: #dae9da;"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- end chat-history -->
                    
                            <div class="chat-message clearfix">
                                <textarea name="message-to-send" id="message-to-send" placeholder="Type your message" rows="3"></textarea>
                    
                                <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
                                <i class="fa fa-file-image-o"></i>
                    
                                <button>Send</button>
                            </div>
                            <!-- end chat-message -->
                        </div>
                        <!-- end chat -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</x-app-layout>