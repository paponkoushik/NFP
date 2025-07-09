@extends('frontend.layouts.app')

@section('content')
    <section class="page-header custom">
        <!-- <div class="header-image"></div> -->
        <div class="container-xxl">
            <div class="row">
                <div class="col-12 position-relative">
                    <div class="content d-flex flex-column justify-content-center">
                        <div class="breadcrumbs">
                            <a href="/" class="text-secondary">Home</a> <i class="bx bx-chevrons-right"></i>
                            <a href="#" class="text-white">Organisations</a>
                        </div>
                        <h2 class="title text-white">
                            List of organisatoins
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="charity-details my-5">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3 py-2">
                        <div class="d-flex">
                            <div class="btn-group">
                                <button type="button" class="btn dropdown-toggle ms-2 dropdown-toggle border" data-bs-toggle="dropdown">Post Type</button>
                                <div class="dropdown-menu"><a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Wanting </a> <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Offering </a></div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn dropdown-toggle ms-2 dropdown-toggle border" data-bs-toggle="dropdown">Category</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> New </a> <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> In-Progress </a>
                                    <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Invalid </a> <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Completed </a>
                                    <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Cancelled </a>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn dropdown-toggle ms-2 dropdown-toggle border" data-bs-toggle="dropdown">Location</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Location 1 </a> <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Location 2 </a>
                                    <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Location 3 </a> <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Location 4 </a>
                                    <a class="dropdown-item py-1 text-uppercase" href="javascript:void(0);"> Location 5 </a>
                                </div>
                            </div>

                            <input class="form-control ms-2" placeholder="Form Date" />
                            <input class="form-control ms-2" placeholder="To Date" />
                        </div>
                        <div><input class="form-control" wire:model.debounce.800ms="filters.search" placeholder="Search..." /></div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 org-item">
                        <div class="org-image-section">
                            <a href="/organisations/12">
                                <img class="img-fluid org-img" src="{{ asset('/assets/img/backgrounds/example-2-1.jpg') }}" alt="Card image cap" />
                                <div class="org-img-location-gallery">
                                    <h6 class="m-0 text-white">
                                        Kolabagan Area
                                    </h6>
        
                                    <h6 class="m-0 text-white">
                                        5 
                                    </h6>
                                </div>
                            </a>
                        </div>

                        <div class="card-body">
                            <a href="/organisations/12">
                                <h5 class="text-truncate">Merge with another not for profit organisation</h5>
                            </a>
                            <p class="org-description">
                                Est quae perferendis minima adipisci rerum. Quos nobis libero dolor saepe. Vel sunt dolores sed ab et molestiae doloribus. Non dolor voluptas excepturi nihil provident reprehenderit. Ipsum consectetur vero nam sunt velit et
                                doloribus. Voluptatum beatae voluptas non aut consequatur vero ut. Est eum dolor occaecati ad rem deleniti. Iure nulla officiis quam quis inventore. Dolore in dolorem aliquam. Quam sunt eum autem temporibus in mollitia
                                nesciunt. Vero qui molestiae quia dolores rem optio sed. Architecto et qui ipsa et. Iusto illo quia accusamus magnam illo. Hic adipisci sint temporibus voluptatibus dicta tenetur. In hic eveniet eos voluptatem id sunt. Quo
                                doloribus eius consectetur cumque eveniet qui. Qui autem saepe commodi necessitatibus. A nisi totam aut neque. Maiores sapiente eos nulla rerum. Possimus eos voluptatum magni qui qui. Minima cumque nisi hic voluptas ut
                                soluta.
                            </p>
                            
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> {{ rand(50, 458) }}</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> {{ rand(11, 99) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection