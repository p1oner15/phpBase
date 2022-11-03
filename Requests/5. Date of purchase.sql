select clients.full_name, count(clients.date_of_purchase) as кол_во_проданных_авто_в_первом_квартале
from clients
where quarter(clients.date_of_purchase) = 1;