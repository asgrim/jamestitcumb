
~~~
<asgrim> richsage: surely pentests would ignore such trivally workaroundable "features" like autocomplete="off"? A hacker certinaly isn't going to obey autocomplete="off", so why should any pentest?
<richsage> asgrim: it's less about hacking and more about general data security in points
<richsage> (for context: https://twitter.com/rich_81/status/410347697065824257 )
<asgrim> yeah that's my point, autocomplete="off" is not, and should not, be considered to be any form of security for anything, ever
<richsage> asgrim: it's not a replacement for "all the security things" :)
<asgrim> the only reason autocomplete="off" exists from what I can see is so that misguided banks can force people to manually type their internet banking passwords
<asgrim> or for CAPTCHAs perhaps
<richsage> asgrim: https://www.owasp.org/index.php/Testing_for_Vulnerable_Remember_Password_and_Pwd_Reset_(OWASP-AT-006)
<richsage> (near the bottom)
<asgrim> yeah I get that, but saving passwords is a user preference... websites should not override user preferences. Otherwise, all you achieve is people using weaker passwords that are easier for the end user to remember
<asgrim> if I site allows browser to remember the password, they end user is much more likely to use a password with higher entropy. If the user is forced to type it every time, they are going to use a weaker password. Which is more desireable?
<richsage> that depends on your password policy surely
<asgrim> that's a different discussion - password policies are stupid as well. Our sysadmin almost introduced stupid password policies, until I taught him that doing so would mean people using weaker passwords (e.g. for a monthly reset, "january+2014" might be the password of the month)
<asgrim> password policies make passwords much easier to hack and/or socially engineer
<asgrim> (imo)
<asgrim> if a user wants to use a weak, easy to remember password, they will, no amount of forcing user prefs like disabling remembering passwords will help
<asgrim> soz
<asgrim> </rant>
<asgrim> :)
~~~
