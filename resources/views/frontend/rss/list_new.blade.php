
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Tin tức Xổ số - Những tin tức xổ số hot nhất</title>
        <link>{{route('news.list')}}</link>

        <description>Tin tức Xổ số - Những tin tức xổ số hot nhất</description>
        <!-- <language>en-gb</language> -->
        <copyright>xosotailoc.live</copyright>
        <lastBuildDate>{{ now()->format('d-m-Y H:i:s') }}</lastBuildDate>
        <ttl>20</ttl>
            @foreach($items as $item)
            <item>
                <title>{{$item->title}}</title>
                <description>{{$item->des}}</description>
                <link>{{route('news.post', $item->slug)}}</link>
                <pubDate>{{$item->updated_at}}</pubDate>
            </item>
           @endforeach
    </channel>
</rss>
