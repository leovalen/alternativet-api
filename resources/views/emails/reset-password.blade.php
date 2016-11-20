<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Velkommen til Alternativet</title>
    @include('emails.partials.style')
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="alert alert-info">
                            Sett nytt passord
                        </td>
                    </tr>
                    <tr>
                        <td class="content-wrap">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        Hei {{ $user->name }},
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <a href="{{ config('app.url') . "/nytt-passord/" . $token->token }}">Følg denne lenken for å sette nytt passord til kontoen din på alternativet.party »</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Du mottar denne e-posten fordi du har bedt om å sette nytt passord, eller fordi du ikke har satt passord på kontoen din enda.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Med vennlig hilsen,<br />
                                        Alternativet
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">
                                Du har mottatt denne meldingen fordi du er registrert hos <a href="https://alternativet.party">Alternativet</a>.<br />
                                Postadresse: Alternativet, Turbinveien 1, 0195 OSLO<br />
                                Telefon 46665333 | org. nr. 916483511</td>
                        </tr>
                        <tr>
                            <td class="aligncenter content-block"><a href="mailto:medlem@alternativet.party">Meld om feil »</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>