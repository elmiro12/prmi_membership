@php
    use App\Helpers\AppSetting;

    $logoUrl = AppSetting::logo();
    $logoPath = custom_public_path(str_replace(url('/'), '', $logoUrl));
    $abs_path_bg = custom_public_path('uploads/logo/small-logo-trs.png');
    
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 5px; }
        body {
            margin: 5px;
            font-family: Arial, sans-serif;
            background: #f7f7fa;
            font-size: 12px;
            padding: 0px;
        }
        .card {
            width: 91%;
            height: 86%;
            border-radius: 10px;
            border: 1px solid #999;
            padding: 16px;
            position: relative;
            background-image:url("{{ $abs_path_bg }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 250px; /* sesuaikan */
            overflow: hidden;
        }
        .header {
            position: absolute;
            top: 10px;
            right: 16px;
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
        }
        .logo {
            width: 60px;
            margin-bottom: 16px;
        }
        .left-content {
            float: left;
            width: 65%;
        }
        .right-photo {
            margin-top:80px;
            float: right;
            width: 30%;
            text-align: center;
        }
        .photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #aaa;
        }
        .title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .line {
            font-size: 13px;
            margin-bottom: 6px;
        }
        .member-id{
            font-size:25px;
        }
        .footer {
            position: absolute;
            bottom: 12px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">PRMI REGIONAL AMBON MEMBERSHIP CARD</div>
        <div class="clearfix">
            <div class="left-content">
                <img src="{{ $logoPath }}" class="logo" alt="Logo">
                <div class="title">MEMBERSHIP PRMI</div>
                <div class="line member-id"><strong>{{ $member->membership->membership_number ?? '-' }}</strong></div>
                <div class="line"><strong>{{ strtoupper($member->fullname) }}</strong></div>
                <div class="line">{{ ucfirst(strtolower($member->address)) }}</div>
                <div class="line">{{ strtoupper($member->membership->membershipType->type ?? '-') }}</div>
            </div>
            <div class="right-photo">
                @php
                    $photoPath = 'uploads/member_photos/' . $member->photo;
                    if (!$member->photo || $member->photo === 'default.jpg') {
                        $photoPath = $member->gender === 'Female'
                            ? 'images/default-female.png'
                            : 'images/default-male.png';
                    }
                    $abs_photo = custom_public_path($photoPath);
                @endphp
                <img src="{{ $abs_photo }}" alt="Foto" class="photo">
            </div>
        </div>
        <div class="footer">
            BERLAKU SAMPAI @tanggalIndo($member->membership->expiry_date)
        </div>
    </div>
</body>
</html>
