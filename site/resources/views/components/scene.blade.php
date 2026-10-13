@props(['motif' => 'arch', 'variant' => 0])
{{-- Original vector illustration, not a photograph or evidence of a venue. --}}
<svg class="scene scene-{{ $motif }} scene-variant-{{ $variant }}" viewBox="0 0 800 500" preserveAspectRatio="xMidYMid slice" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <rect width="800" height="500" fill="currentColor" class="scene-sky"/>
    <circle cx="640" cy="110" r="65" fill="#ffe4a1" opacity=".9"/>
    <path d="M0 285C120 265 170 290 280 265S480 280 610 250 760 260 800 240V500H0Z" fill="#edf5fb" opacity=".3"/>
    @if(in_array($motif, ['arch', 'passport']))
        <path d="M0 380H800V500H0Z" fill="#1e446f"/>
        <g fill="#173960"><path d="M75 385V230H150V385ZM170 385V185H237V385ZM275 385V285H339V385ZM530 385V210H600V385ZM630 385V165H700V385ZM735 385V260H795V385Z"/></g>
        <g fill="#48799f"><path d="M35 405V285H104V405ZM150 405V265H202V405ZM244 405V240L310 215V405ZM565 405V275H637V405ZM670 405V255L732 235V405Z"/></g>
        <path d="M390 405V255H408V188H420V115H431V62H438V115H449V188H461V255H479V405Z" fill="#a5c7d9"/>
        <path d="M434 62V16" stroke="#c7deea" stroke-width="3"/>
        <g stroke="#c9dfeb" stroke-width="4" opacity=".45"><path d="M88 255H138M88 280H138M88 305H138M185 212H222M185 239H222M185 266H222M648 190H684M648 220H684M648 250H684M580 300H620M580 328H620M261 265H295M261 290H295"/></g>
        <path d="M0 425C240 400 530 453 800 416" stroke="#89c5dd" stroke-width="3"/>
        <path d="M90 450H300M380 470H630M670 445H780" stroke="#e5f4ff" stroke-width="2" opacity=".3"/>
    @elseif(in_array($motif, ['ship', 'sail']))
        <path d="M0 310Q180 275 370 308T800 302V500H0Z" fill="#288aa6"/>
        <path d="M0 370Q180 335 380 366T800 360V500H0Z" fill="#14617e"/>
        <g fill="#315b7c" opacity=".65"><path d="M25 305V190H70V305ZM90 305V140H130V305ZM150 305V215H210V305ZM625 305V190H680V305ZM700 305V155H752V305Z"/></g>
        @if($motif === 'sail')
            <path d="M325 350V96L194 350Z" fill="#f7f6e8"/><path d="M343 350V136L493 350Z" fill="#d3e7ec"/><path d="M335 82V375" stroke="#123d5d" stroke-width="6"/>
            <path d="M165 375H540L506 415H218Z" fill="#fff5d9"/><path d="M220 393H491" stroke="#cfb278" stroke-width="4"/>
        @else
            <path d="M160 347H580L540 410H216Z" fill="#e5d8b3"/><path d="M238 275H492L535 345H196Z" fill="#f6efdd"/>
            <path d="M257 295H286V329H257ZM308 295H337V329H308ZM359 295H388V329H359ZM410 295H439V329H410ZM461 295H485V329H461Z" fill="#315e79"/>
            <path d="M229 270H513M198 354H562" stroke="#ab8057" stroke-width="7"/>
        @endif
        <g stroke="#a2dce5" stroke-width="3" opacity=".55"><path d="M55 426H175M290 446H535M580 408H760M20 478H260M620 470H790"/></g>
    @elseif($motif === 'sun')
        <path d="M0 320C150 205 260 365 420 288S650 190 800 275V500H0Z" fill="#deb078"/>
        <path d="M0 350C210 400 280 220 495 310S665 425 800 352V500H0Z" fill="#ba784b"/>
        <path d="M0 455C180 315 350 442 490 395S710 356 800 437V500H0Z" fill="#704c47"/>
        <path d="M280 500Q370 385 620 388" stroke="#f4c797" stroke-width="5" opacity=".5"/>
        <path d="M89 330V278M89 290L64 274M89 299L112 282" stroke="#734f49" stroke-width="7" stroke-linecap="round"/>
    @else
        <path d="M0 395L165 170L315 330L435 125L650 355L800 230V500H0Z" fill="#5c7d8f"/>
        <path d="M165 170L118 244L167 220L202 241ZM435 125L386 220L435 188L481 215Z" fill="#c8dce0"/>
        <path d="M0 442L220 316L440 428L660 285L800 360V500H0Z" fill="#2f5669"/>
        <path d="M310 500Q380 435 470 442T710 405" stroke="#cca779" stroke-width="10"/>
    @endif
</svg>
