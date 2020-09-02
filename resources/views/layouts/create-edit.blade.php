@extends('layouts.app')

@section('content')
    <div class="row mt">
        <div class="col-lg-{{ $config['size'] }}">
            <section class="panel">
                <div class="panel-body minimal">
                    <div class="mail-option">
                        <h4><i class="fa fa-angle-right"></i> {{ $config['title'] }}</h4>
                        <hr>
                        <form class="cmxform form-horizontal style-form" id="signupForm" method="post"
                              action="{{ $config['route'] }}">
                            @csrf
                            @method($config['method'])
                            @if(last(request()->segments()) == 'create')
                                <input type="hidden" value="{{ \Illuminate\Support\Str::uuid() }}" name="uuid">
                            @endif
                            @foreach($forms as $form)
                                @if($form['type'] == 'textarea')
                                    <div class="form-group @error($form['name']) has-error @endif">
                                        <label for="{{ $form['name'] }}"
                                               class="control-label col-lg-2">{{ $form['label'] }}
                                            @if($form['mandatory']==true)
                                                <span style="color: red;">*</span>
                                            @endif
                                        </label>
                                        <div class="col-lg-5">
                                              <textarea class="form-control" name="{{ $form['name'] }}"
                                                        placeholder="{{ $form['place_holder'] ? $form['place_holder'] : '' }}">{{ isset($data) ? $data[$form['name']] : old($form['name']) }}</textarea>
                                        </div>
                                        @error($form['name'])
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif($form['type'] === 'select_option')
                                    <div class="form-group @error($form['name']) has-error @endif">
                                        <label for="{{ $form['name'] }}"
                                               class="control-label col-lg-2">{{ $form['label'] }}
                                            @if($form['mandatory']==true)
                                                <span style="color: red;">*</span>
                                            @endif
                                        </label>
                                        <div class="col-lg-5">
                                            <select class="form-control select2" name="{{ $form['name'] }}">
                                                <option value="">--- Please Select ---</option>
                                                @foreach(${$form['variable']} as $row)
                                                    <option value="{{ $row[$form['option_value']] }}"
                                                            @isset($data)
                                                            @if($data[$form['name']] == $row[$form['option_value']]) selected @endif
                                                        @endisset
                                                    >{{ $row[$form['option_text']] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error($form['name'])
                                            <p class="help-block">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group @error($form['name']) has-error @endif">
                                        <label for="{{ $form['name'] }}"
                                               class="control-label col-lg-2">{{ $form['label'] }}
                                            @if($form['mandatory']==true)
                                                <span style="color: red;">*</span>
                                            @endif
                                        </label>
                                        <div class="col-lg-5">
                                            <input class=" form-control" id="{{ $form['name'] }}"
                                                   name="{{ $form['name'] }}"
                                                   type="{{ $form['type'] }}" placeholder="{{ $form['place_holder'] }}"
                                                   value="{{ isset($data) ? $data[$form['name']] : old($form['name']) }}"/>
                                            @error($form['name'])
                                            <p class="help-block">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                            @endforeach

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-theme" type="submit">Save</button>
                                    <button class="btn btn-theme04" type="button" onclick="history.back()">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
@push('css')
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({

        });
    </script>
@endpush
