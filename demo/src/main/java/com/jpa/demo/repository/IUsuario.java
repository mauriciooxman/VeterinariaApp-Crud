package com.jpa.demo.repository;

import com.jpa.demo.model.Usuario;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;


@Repository
public interface IUsuario extends JpaRepository<Usuario, Long> {
}
