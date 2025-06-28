<x-pdf-layout>
    @php
        $prependedString = str_repeat('0', 4 - strlen($student->id)) . $student->id;

        function image($path)
        {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

    @endphp

    <div class="text-center" style="margin: 20px 0;">
        <h1>Entrance Examination Form / Admission 2024/2025</h1>
    </div>

    <div style="margin-bottom: 10px">
        <span>Application Number:
        <strong>FHS{{ $student->option === 1 ? 'MLS' : 'NUS' }}24{{ $prependedString }}</strong></span>
        <span style="color: orangered; float: right;">EXAMINATION DATE: 14/09/2024</span>
    </div>

    <h4>Personal Information</h4>
    <table>
        <tr>
            <td>Name: <strong>{{ $student->name }} {{ $student->surname }}</strong></td>
            <td>Email: <strong>{{ $student->email }}</strong></td>
            <td rowspan="4" style="text-align: center; padding: 0;"><img src="{{ image('storage/' . $student->passport) }}"
                    alt="" width="120" height="120"></td>
        </tr>
        <tr>
            <td>Date of birth: <strong>{{ $student->dob }}</strong></td>
            <td>Place of birth: <strong>{{ $student->pob }}</strong></td>
        </tr>
        <tr>
            <td>Gender: <strong>{{ ucfirst($student->gender) }}</strong></td>
            <td>NIC: <strong>{{ $student->idc_number }}</strong></td>
        </tr>
        <tr>
            <td>Nationality: <strong>{{ $student->country }}</strong></td>
            <td>Tel: <strong>{{ $student->telephone }}</strong></td>
        </tr>
        <tr>
            <td colspan="3">Bank Reference: <strong>{{ $student->bankref }}</strong></td>
        </tr>
    </table>


    <h4>Examination information</h4>
    <table>
        <tr>
            <td>Option</td>
            <td>
                <strong>
                    {{ \App\Models\DepartmentOption::where('id', $student->option)->first()->name }}
                </strong>
            </td>
        </tr>
        <tr>
            <td>Examination Centre</td>
            <td>
                <strong>
                    {{ $student->examCenter->name }}
                </strong>
            </td>
        </tr>
        <tr>
            <td>Examination Language</td>
            <td>
                <strong>
                    {{ $student->primary_language == 'en' ? 'English' : 'French' }}
                </strong>
            </td>
        </tr>
    </table>

    @if (count($qualifications) > 0)
        <h4>Qualifications</h4>
        <table>
            @foreach ($qualifications as $qualification)
                <tr>
                    <td>Type: <strong>{{ $qualification->qualificationType->name }}</strong></td>
                    <td>
                        Grade/Points: <strong>{{ $qualification->points }}</strong>
                    </td>
                    <td>
                        Year: <strong>{{ $qualification->year }}</strong>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    <h3>BRING THE FOLLOWING TO YOUR EXAMINATION CENTRE</h3>
    <hr>
    <ol>
        <li>A registration form to be completed online at the website of the
            <a href="https://fhs.uniba.cm">Faculty of Health Sciences (FHS)</a>
        </li>
        <li> A certified true copy of birth certificate dated not more than six (6) months</li>
        <li>Medical Certificate signed by a competent public service medical doctor.</li>
        <li>A certified true copy of GCE A/L or Baccalaureate or equivalent diploma dated not more than six (6) months
        </li>
        <li>A certified true copy of GCE O/L or Probatoire or equivalent diploma dated not more than six (6) months
        </li>
        <li>A receipt of payment of the sum of twenty thousand (20,000) FCFA being a non-refundable registration fee to
            be paid into FHS’s NFC Bank Account No. 10025 00030 17101020844 28, <strong>No other form of payment will be
                accepted</strong></li>
        <li>One A4 size. Self-addressed stamped envelope</li>
        <li>Four passport-size photographs</li>
    </ol>
</x-pdf-layout>
