@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>会社情報</h1>
        <table class="table">
            <head>
                <tr>
                    <th>会社名</th>
                    <th>代表者名</th>
                    <th>設立日</th>
                    <th>郵便番号</th>
                    <th>住所</th>
                    <th>事業内容</th>
                </tr>
            </head>
            <body>
                @foreach($companies as $company)
                <tr>
                    <td>{{ $company->company_name }}</td>
                    <td>{{ $company->representative }}</td>
                    <td>{{ $company->establishment_date }}</td>
                    <td>{{ $company->post_code}}</td>
                    <td>{{ $company->address }}</td>
                    <td>{{ $company->business_description }}</td>
                    <td>
                        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-info">詳細</a>
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">編集</a>
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </body>
        </table>
    </div>
@endsection


