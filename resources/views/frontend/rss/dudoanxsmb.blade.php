<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Dự đoán XSMB</title>
        <link>{{route('dudoan.xsmb')}}</link>

        <description>Dự đoán XSMB</description>
        <!-- <language>en-gb</language> -->
        <copyright>xosotailoc.vip</copyright>
        <lastBuildDate>{{ now()->format('d-m-Y H:i:s') }}</lastBuildDate>
        <ttl>20</ttl>
            @foreach($items as $item)
            <item>
                <title>{{$item->title}}</title>
                <description>{{$item->des}}</description>
                <link>{{route('dudoan.xsmb.date',date('d-m-Y', strtotime($item->date)))}}</link>
                <pubDate>{{$item->date}}</pubDate>
            </item>
           @endforeach
    </channel>
</rss>
