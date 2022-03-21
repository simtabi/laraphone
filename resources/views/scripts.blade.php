@laraphoneJs

<script>
    var laraphoneConfig = @json(config('laraphone'));
</script>

<script wire:ignore>
    document.dispatchEvent(new Event('telDOMChanged'));
</script>