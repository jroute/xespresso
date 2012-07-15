
function chksignnum(signnum) {

  // 주민번호의 형태와 7번째 자리(성별) 유효성 검사
  fmt = /^\d{6}-[1234]\d{6}$/;
  if (!fmt.test(signnum)) {
    alert("잘못된 주민등록번호입니다."); 
    return false;
  }

  // 날짜 유효성 검사
  birthYear = (signnum.charAt(7) <= "2") ? "19" : "20";
  birthYear += signnum.substr(0, 2);
  birthMonth = signnum.substr(2, 2) - 1;
  birthDate = signnum.substr(4, 2);
  birth = new Date(birthYear, birthMonth, birthDate);

  if ( birth.getYear() % 100 != signnum.substr(0, 2) ||
       birth.getMonth() != birthMonth ||
       birth.getDate() != birthDate) {
    alert("잘못된 주민등록번호입니다."); return;
  }

  // Check Sum 코드의 유효성 검사
  buf = new Array(13);
  for (i = 0; i < 6; i++) buf[i] = parseInt(signnum.charAt(i));
  for (i = 6; i < 13; i++) buf[i] = parseInt(signnum.charAt(i + 1));

  multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
  for (i = 0, sum = 0; i < 12; i++) sum += (buf[i] *= multipliers[i]);

  if ((11 - (sum % 11)) % 10 != buf[12]) {
    alert("잘못된 주민등록번호입니다."); return false;
  }

	return true;
}