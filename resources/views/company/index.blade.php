@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $company->company_name }}の詳細情報</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">会社名: {{ $company->company_name }}</h5>
                <p class="card-text"><strong>代表者名:</strong> {{ $company->representative }}</p>
                <p class="card-text"><strong>設立日:</strong> {{ $company->establishment_date }}</p>
                <p class="card-text"><strong>郵便番号:</strong> {{ $company->post_code }}</p>
                <p class="card-text"><strong>住所:</strong> {{ $company->address }}</p>
                <p class="card-text"><strong>事業内容:</strong> {{ $company->business_description }}</p>

                <a href="{{ route('company.edit', $company->id) }}" class="btn btn-warning">編集</a>
                <form action="{{ route('company.destroy', $company->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <a href="{{ route('company.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
@endsection
