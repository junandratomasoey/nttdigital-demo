@if(app()->bound('demo'))
<div style="border:1px solid #f59e0b;background:#fffbeb;color:#78350f;border-radius:10px;padding:12px 14px;font-size:13px;line-height:1.6">
    <strong>Akun demo</strong><br>
    Email: <code style="user-select:all">{{ 'admin@' . app('demo')->jenis . '.demo' }}</code><br>
    Kata sandi: <code style="user-select:all">{{ config('demo.admin_password') }}</code><br>
    <span style="opacity:.8">Data kembali seperti semula setiap pukul 02.00 WITA.</span>
</div>
@else
<div style="border:1px solid #ef4444;background:#fef2f2;color:#7f1d1d;border-radius:10px;padding:12px 14px;font-size:13px">
    Buka panel admin dari alamat demo, misalnya <code>demo-desa.{{ config('demo.domain') }}/admin</code>.
</div>
@endif
