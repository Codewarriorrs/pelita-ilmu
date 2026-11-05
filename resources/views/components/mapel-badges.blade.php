@props(['mapels' => []])

@if(!empty($mapels) && count($mapels) > 0)
    <div class="flex flex-wrap gap-1 mt-1">
        @foreach($mapels as $m)
            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                {{ $m }}
            </span>
        @endforeach
    </div>
@endif

