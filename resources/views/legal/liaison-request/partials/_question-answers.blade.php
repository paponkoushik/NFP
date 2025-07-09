@php 
    $questions = [
        'Think Of your favorite animal, place, and color now say one of them! What Did you say?',
        'What is -100,000 - -100,000? Is it 200,000? And how?',
        'Here\'s an easy but dumb riddle. If you sit here, and live here then where do you stand?',
        'Here is another question you will answer correctly!!! ',
        'Riddle: My shirt is red, my fur is yellow I have no head and I like something sweet! Who am I?'
    ];
@endphp

<div class="tab-pane fade" id="qa" role="tabpanel">
    <div class="qa-box">
        <div class="d-flex justify-content-between">
            <p class="text-primary-dark fw-bold text-uppercase">Q&amp;A: Title of Question List</p>
            <div class="me-2">
                <button type="button" class="btn btn-warning bg--warning w-134 ml-1 btn-sm">Previous</button> 
                <button type="button" class="btn btn-info bg--info w-134 ml-1 btn-sm">Save &amp; Next</button>
            </div>            
        </div>

        @foreach($questions as $key => $qa)
            <div class="row no-gutters py-2 align-items-start">
                <div class="col-md-9 custom-width-flex">
                    <div class="bg-lighter rounded-3 p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <p class="fw-semibold pe-2 mb-0 text-primary-dark">0{{ ++$key }}.</p>
                                <p class="mb-1 fw-normal">{{ $qa }}</p>
                            </div>
                        </div>
                        <!---->
                    </div>
                </div>
                
                <div class="col-md-3 px-0">
                    <div class="form-check form-check-inline me-0">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1{{ $key }}" value="option2" />
                        <label class="form-check-label font-12 fw-normal" for="inlineRadio1{{ $key }}">Yes</label>
                    </div>

                    <div class="form-check form-check-inline me-0">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2{{ $key }}" value="option2" />
                        <label class="form-check-label font-12 fw-normal" for="inlineRadio2{{ $key }}">No</label>
                    </div>

                    <div class="form-check form-check-inline me-0">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3{{ $key }}" value="option2" />
                        <label class="form-check-label font-12 fw-normal" for="inlineRadio3{{ $key }}">N/A</label>
                    </div>                
                </div>
            </div>
        @endforeach
    </div>
</div>