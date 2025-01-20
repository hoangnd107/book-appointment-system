@extends('admin.layout')
@section('title')
    {{ __('message.Languages_Translation') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <h4 class="card-title float-left mt-3 ml-3">{{ __('message.Languages_Translation') }}</h4>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a href="{{ url('admin/languages/en') }}"
                                            class="nav-link {{ $lang == 'en' ? 'active' : '' }}" id="en_lang"
                                            role="tab" aria-controls="home"
                                            aria-selected="{{ $lang == 'en' ? 'true' : 'false' }}">{{ __('message.english') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/languages/ar') }}"
                                            class="nav-link {{ $lang == 'ar' ? 'active' : '' }}" id="ar_lang"
                                            role="tab" aria-controls="contact"
                                            aria-selected="{{ $lang == 'ar' ? 'true' : 'false' }}">{{ __('message.arabic') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/languages/fr') }}"
                                            class="nav-link {{ $lang == 'fr' ? 'active' : '' }}" id="fr_lang"
                                            role="tab" aria-controls="home3"
                                            aria-selected="{{ $lang == 'fr' ? 'true' : 'false' }}">{{ __('message.french') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/languages/es') }}"
                                            class="nav-link {{ $lang == 'es' ? 'active' : '' }}" id="es_lang"
                                            role="tab" aria-controls="home4"
                                            aria-selected="{{ $lang == 'es' ? 'true' : 'false' }}">{{ __('message.spanish') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/languages/pt') }}"
                                            class="nav-link {{ $lang == 'pt' ? 'active' : '' }}" id="pt_lang"
                                            role="tab" aria-controls="home5"
                                            aria-selected="{{ $lang == 'pt' ? 'true' : 'false' }}">{{ __('message.portuguese') }}</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="myTabContent">
                                    <!-- English Tab -->
                                    <div class="tab-pane fade {{ $lang == 'en' ? 'show active' : '' }}" id="home"
                                        role="tabpanel" aria-labelledby="en_lang">
                                        <div class="table-responsive p-3">
                                        <table id="en_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('message.Key') }}</th>
                                                    <th>{{ __('message.Value') }}</th>
                                                    <th>{{ __('message.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($messages as $key => $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                        <td>
                                                            <a href="{{ route('languages.edit', ['lang' => $lang, 'key' => $key]) }}"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            {{-- <form action="{{ route('languages.destroy', ['lang' => $lang, 'key' => $key]) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- Arabic Tab -->
                                    <div class="tab-pane fade {{ $lang == 'ar' ? 'show active' : '' }}" id="contact"
                                        role="tabpanel" aria-labelledby="ar_lang">
                                        <div class="table-responsive p-3">
                                        <table id="ar_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('message.Key') }}</th>
                                                    <th>{{ __('message.Value') }}</th>
                                                    <th>{{ __('message.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($messages as $key => $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                        <td>
                                                            <a href="{{ route('languages.edit', ['lang' => $lang, 'key' => $key]) }}"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            {{-- <form action="{{ route('languages.destroy', ['lang' => $lang, 'key' => $key]) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- French Tab -->
                                    <div class="tab-pane fade {{ $lang == 'fr' ? 'show active' : '' }}" id="home3"
                                        role="tabpanel" aria-labelledby="fr_lang">
                                        <div class="table-responsive p-3">
                                        <table id="fr_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('message.Key') }}</th>
                                                    <th>{{ __('message.Value') }}</th>
                                                    <th>{{ __('message.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($messages as $key => $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                        <td>
                                                            <a href="{{ route('languages.edit', ['lang' => $lang, 'key' => $key]) }}"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            {{-- <form action="{{ route('languages.destroy', ['lang' => $lang, 'key' => $key]) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- spinach  Tab -->
                                    <div class="tab-pane fade {{ $lang == 'es' ? 'show active' : '' }}" id="home4"
                                        role="tabpanel" aria-labelledby="es_lang">
                                        <div class="table-responsive p-3">
                                        <table id="es_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('message.Key') }}</th>
                                                    <th>{{ __('message.Value') }}</th>
                                                    <th>{{ __('message.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($messages as $key => $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                        <td>
                                                            <a href="{{ route('languages.edit', ['lang' => $lang, 'key' => $key]) }}"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            {{-- <form action="{{ route('languages.destroy', ['lang' => $lang, 'key' => $key]) }}" method="POST" style="display:inline;">
                                                             @csrf
                                                             @method('DELETE')
                                                             <button type="submit" class="btn btn-danger">Delete</button>
                                                         </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- Portuguese Tab -->
                                    <div class="tab-pane fade {{ $lang == 'pt' ? 'show active' : '' }}" id="home5"
                                        role="tabpanel" aria-labelledby="pt_lang">
                                        <div class="table-responsive p-3">
                                        <table id="pt_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('message.Key') }}</th>
                                                    <th>{{ __('message.Value') }}</th>
                                                    <th>{{ __('message.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($messages as $key => $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                        <td>
                                                            <a href="{{ route('languages.edit', ['lang' => $lang, 'key' => $key]) }}"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            {{-- <form action="{{ route('languages.destroy', ['lang' => $lang, 'key' => $key]) }}" method="POST" style="display:inline;">
                                                             @csrf
                                                             @method('DELETE')
                                                             <button type="submit" class="btn btn-danger">Delete</button>
                                                         </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('footer')
@stop
