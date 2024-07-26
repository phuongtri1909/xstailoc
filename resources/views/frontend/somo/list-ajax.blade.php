<table>
    <tbody id="article-list">
    <tr>
        <th>STT</th>
        <th>Chiêm bao thấy</th>
        <th>Con số giải mã</th>
    </tr>
    @php $d=1; @endphp
    @foreach($somo as $item)
        <tr>
            <td class="center">{{$d++}}</td>
            <td class="center">{{$item->mo}}</td>
            <td class="center"><span class="red-text bold">{{$item->so}}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>