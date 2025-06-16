<?php
function group1()
{
  //3: instruktur
  return ['3'];
}

function group2()
{
  //5: student
  return ['5'];
}

function group3()
{
  //1: administrator, 2: admin, 4: PIC
  return ['1', '2', '4'];
}
function role_available()
{
  //3 Intsruktur, 5 Student
  return ['3', '5'];
}

//in_array
function canaddmodul($role)
{
  if (in_array($role, group1())) {
    return true;
  }
}
