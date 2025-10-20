@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-md py-10">
    <h1 class="text-2xl font-semibold mb-6">Verifikasi Email dengan OTP</h1>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <p class="mb-4">Kami telah mengirimkan kode OTP 6 digit ke email <strong>{{ $user->email }}</strong>. Masukkan kode tersebut di bawah ini. Kode berlaku selama 10 menit.</p>

        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium">Kode OTP</label>
                <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" required class="mt-1 w-full border rounded px-3 py-2" placeholder="000000" />
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('otp.send') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full bg-gray-100 text-gray-900 py-2 rounded hover:bg-gray-200">Kirim Ulang Kode</button>
        </form>

        <p class="text-sm text-gray-600 mt-4">Jika tidak menemukan email, periksa folder Spam/Promotions.</p>
    </div>
</div>
@endsection
