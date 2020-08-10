SELECT REVERSE(SUBSTRING(`phone_number`, 2)) as 'rebmuneohp'
FROM `distrib`
WHERE `phone_number` LIKE '05%';
