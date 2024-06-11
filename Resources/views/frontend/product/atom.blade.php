<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<feed xmlns="http://www.w3.org/2005/Atom">
    @foreach($meta as $key => $metaItem)
        @if($key === 'link')
            <{{ $key }} href="{{ url($metaItem) }}"></{{ $key }}>
        @elseif($key === 'title')
            <{{ $key }}><![CDATA[{{ $metaItem }}]]></{{ $key }}>
        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif
    @endforeach
    @foreach($items as $item)
        <entry>
            <title><![CDATA[{{ $item->title }}]]></title>
            <link rel="alternate" href="{{ url($item->link) }}" />
            <id>{{$item->id}}</id>
            @if($item->__isset('enclosure'))
              <enclosure url="{{ url($item->enclosure) }}" length="{{ $item->enclosureLength }}" type="{{ $item->enclosureType }}" />
            @endif
            <description>{{$item->description}}</description>
            <availability>{{$item->availability}}</availability>
            <condition>{{$item->condition}}</condition>
            <price>{{$item->price}}</price>
            <image_link>{{$item->image_link}}</image_link>
            <brand>{{$item->brand}}</brand>
        </entry>
    @endforeach
</feed>