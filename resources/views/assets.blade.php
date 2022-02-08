@if($type == 'styles')

  @isset($laraphoneCssPath)
    <style>{!! file_get_contents($laraphoneCssPath) !!}</style>
  @endisset
  
@elseif($type == 'scripts')

  @isset($laraphoneJsPath)
    <script>
      var laraphoneConfig = @json(config('laraphone.intlTelInput'));
      {!! file_get_contents($laraphoneJsPath) !!}
    </script>
  @endisset

@endif