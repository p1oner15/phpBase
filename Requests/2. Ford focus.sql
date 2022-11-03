use mydb;
Select price from price_list join models on price_list.id = models.id
where model_name = 'Ford_focus' and transmission = 'automatic';
